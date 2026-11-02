@php
    $posts = app(\App\Services\BlogService::class)->latestPosts(6);
@endphp
<section class="section blog-preview-section">
    <div class="site-shell">
        <div class="section-heading destination-heading blog-heading">
            <div>
                <p class="eyebrow">Travel guides</p>
                <h2>Useful ideas before you book.</h2>
            </div>
            <a class="quiet-link dark" href="{{ config('site.blog_url') }}">View all travel guides →</a>
        </div>
        <div class="blog-card-grid">
            @forelse($posts as $post)
            @php
                $words    = str_word_count(strip_tags($post['post_content']));
                $readMin  = max(1, (int) round($words / 200));
                $cat      = $post['category'] ?: 'Travel guide';
                $date     = date('j M Y', strtotime($post['post_date']));
            @endphp
            <article class="blog-card">
                <a class="blog-card-image" href="{{ htmlspecialchars($post['permalink']) }}" tabindex="-1" aria-hidden="true">
                    @if(!empty($post['thumb_url']))
                        <img src="{{ htmlspecialchars($post['thumb_url']) }}" alt="{{ htmlspecialchars($post['post_title']) }}" loading="lazy">
                    @else
                        <span style="font-size:32px;color:var(--cyan-deep);">✈</span>
                    @endif
                </a>
                <div class="blog-card-meta-bar">
                    <span style="color:var(--navy);font-weight:750;">{{ htmlspecialchars($cat) }}</span>
                    <span class="blog-card-meta-sep">·</span>
                    <time>{{ $date }}</time>
                    <span class="blog-card-meta-sep">·</span>
                    <span>{{ $readMin }} min read</span>
                </div>
                <div class="blog-card-copy">
                    <h3><a href="{{ htmlspecialchars($post['permalink']) }}">{{ htmlspecialchars($post['post_title']) }}</a></h3>
                    <a href="{{ htmlspecialchars($post['permalink']) }}">Read guide →</a>
                </div>
            </article>
            @empty
            <p style="color:var(--muted);grid-column:1/-1;">No posts published yet.</p>
            @endforelse
        </div>
    </div>
</section>
