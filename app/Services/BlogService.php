<?php

namespace App\Services;

use PDO;
use Exception;

class BlogService
{
    private static ?array $cache = null;

    public function latestPosts(int $limit = 6): array
    {
        if (self::$cache !== null) {
            return array_slice(self::$cache, 0, $limit);
        }

        try {
            $pdo = new PDO(
                'mysql:host=' . config('database.connections.blog.host', '127.0.0.1')
                . ';dbname=' . config('database.connections.blog.database', 'flyquick-static-blog')
                . ';charset=utf8mb4',
                config('database.connections.blog.username', 'root'),
                config('database.connections.blog.password', ''),
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );

            $stmt = $pdo->prepare("
                SELECT p.ID, p.post_title, p.post_name, p.post_date, p.post_content,
                    ( SELECT GROUP_CONCAT(t.name ORDER BY t.term_id LIMIT 1)
                      FROM fly_terms t
                      JOIN fly_term_taxonomy tt ON t.term_id = tt.term_id
                      JOIN fly_term_relationships tr ON tt.term_taxonomy_id = tr.term_taxonomy_id
                      WHERE tr.object_id = p.ID AND tt.taxonomy = 'category'
                    ) AS category,
                    ( SELECT pm.meta_value FROM fly_postmeta pm
                      WHERE pm.post_id = p.ID AND pm.meta_key = '_thumbnail_id' LIMIT 1
                    ) AS thumb_id
                FROM fly_posts p
                WHERE p.post_status = 'publish' AND p.post_type = 'post'
                ORDER BY p.post_date DESC
                LIMIT :lim
            ");
            $stmt->bindValue(':lim', 20, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if ($rows) {
                $blogUrl  = rtrim(config('site.blog_url', 'http://flyquick-static.test/blog'), '/');
                $thumbIds = array_filter(array_column($rows, 'thumb_id'));
                $thumbs   = [];

                if ($thumbIds) {
                    $in     = implode(',', array_map('intval', $thumbIds));
                    $thumbs = $pdo->query("
                        SELECT p.ID, pm.meta_value AS file
                        FROM fly_posts p
                        JOIN fly_postmeta pm ON pm.post_id = p.ID AND pm.meta_key = '_wp_attached_file'
                        WHERE p.ID IN ($in)
                    ")->fetchAll(PDO::FETCH_KEY_PAIR);
                }

                foreach ($rows as &$row) {
                    $row['permalink'] = $blogUrl . '/' . $row['post_name'] . '/';
                    $row['thumb_url'] = (!empty($row['thumb_id']) && isset($thumbs[$row['thumb_id']]))
                        ? $blogUrl . '/wp-content/uploads/' . $thumbs[$row['thumb_id']]
                        : null;
                }
                unset($row);
            }

            self::$cache = $rows ?: [];
        } catch (Exception) {
            self::$cache = [];
        }

        return array_slice(self::$cache, 0, $limit);
    }
}
