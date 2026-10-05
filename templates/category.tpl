{extends file="layout.tpl"}

{block name=title}{$category.name}{/block}

{block name=content}
    <h1>{$category.name}</h1>
    <p class="lead text-muted">{$category.description}</p>

    <div class="btn-group mb-4">
        <a href="?sort=date" class="btn btn-outline-secondary btn-sm {if $sort == 'date'}active{/if}">По дате</a>
        <a href="?sort=views" class="btn btn-outline-secondary btn-sm {if $sort == 'views'}active{/if}">По просмотрам</a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        {foreach $posts as $post}
            <div class="col">{include file="_post_card.tpl"}</div>
        {foreachelse}
            <p class="text-muted">В этой категории пока нет статей</p>
        {/foreach}
    </div>

    {if $totalPages > 1}
        <nav class="mt-4">
            <ul class="pagination">
                {for $i = 1 to $totalPages}
                    <li class="page-item {if $i == $page}active{/if}">
                        <a class="page-link" href="?sort={$sort}&page={$i}">{$i}</a>
                    </li>
                {/for}
            </ul>
        </nav>
    {/if}
{/block}
