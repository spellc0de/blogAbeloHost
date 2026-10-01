{extends file="layout.tpl"}

{block name="title"}{$post.title}{/block}

{block name="content"}
    <article class="post-full">
        {if $post.image}
            <img src="/assets/img/posts/{$post.image}" alt="{$post.title}" class="post-full__image">
        {/if}

        <h1>{$post.title}</h1>

        <div class="post-full__meta">
            <span>{$post.published_at|date_format:"%d.%m.%Y"}</span>
            <span>{$post.views} просмотров</span>
            {foreach $post.categories as $cat}
                <a href="/category/{$cat.id}" class="tag">{$cat.name}</a>
            {/foreach}
        </div>

        {if $post.description}
            <p class="post-full__description">{$post.description}</p>
        {/if}

        <div class="post-full__content">
            {$post.content nofilter}
        </div>
    </article>

    {if $related|@count > 0}
        <section class="related">
            <h2>Похожие статьи</h2>
            <div class="post-grid">
                {foreach $related as $related_post}
                    {include file="_post_card.tpl" post=$related_post}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
