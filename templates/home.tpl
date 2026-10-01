{extends file="layout.tpl"}

{block name="title"}Блог - главная{/block}

{block name="content"}
    {if $categories|@count == 0}
        <p>Пока нет опубликованных статей.</p>
    {/if}

    {foreach $categories as $category}
        <section class="category-block">
            <div class="category-block__header">
                <div>
                    <h2>{$category.name}</h2>
                    {if $category.description}
                        <p class="category-block__description">{$category.description}</p>
                    {/if}
                </div>
                <a href="/category/{$category.id}" class="btn">Все статьи</a>
            </div>

            <div class="post-grid">
                {foreach $category.posts as $post}
                    {include file="_post_card.tpl" post=$post}
                {/foreach}
            </div>
        </section>
    {/foreach}
{/block}
