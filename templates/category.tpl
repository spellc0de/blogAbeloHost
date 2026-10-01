{extends file="layout.tpl"}

{block name="title"}{$category.name}{/block}

{block name="content"}
    <div class="category-header">
        <h1>{$category.name}</h1>
        {if $category.description}
            <p>{$category.description}</p>
        {/if}
    </div>

    <div class="sort-bar">
        <span>Сортировка:</span>
        <a href="/category/{$category.id}?sort=date" class="{if $sort == 'date'}active{/if}">по дате</a>
        <a href="/category/{$category.id}?sort=views" class="{if $sort == 'views'}active{/if}">по просмотрам</a>
    </div>

    {if $posts|@count == 0}
        <p>В этой категории пока нет статей.</p>
    {/if}

    <div class="post-grid">
        {foreach $posts as $post}
            {include file="_post_card.tpl" post=$post}
        {/foreach}
    </div>

    {if $pages > 1}
        <div class="pagination">
            {for $i=1 to $pages}
                <a href="/category/{$category.id}?sort={$sort}&page={$i}" class="{if $i == $page}active{/if}">{$i}</a>
            {/for}
        </div>
    {/if}
{/block}
