<article class="post-card">
    <a href="/post/{$post.id}" class="post-card__image">
        {if $post.image}
            <img src="/assets/img/posts/{$post.image}" alt="{$post.title}">
        {else}
            <div class="post-card__no-image"></div>
        {/if}
    </a>
    <div class="post-card__body">
        <h3 class="post-card__title"><a href="/post/{$post.id}">{$post.title}</a></h3>
        {if $post.description}
            <p class="post-card__description">{$post.description}</p>
        {/if}
        <div class="post-card__meta">
            <span>{$post.published_at|date_format:"%d.%m.%Y"}</span>
            <span>{$post.views} просмотров</span>
        </div>
    </div>
</article>
