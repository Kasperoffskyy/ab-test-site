{extends file="layout.tpl"}

{block name=title}{$category.name}{/block}

{block name=content}
    <h1>{$category.name}</h1>
    <p>{$category.description}</p>

    <p>
        Сортировка:
        <a href="?sort=date">по дате</a> |
        <a href="?sort=views">по просмотрам</a>
    </p>

    <ul>
        {foreach $posts as $post}
            <li>
                {if $post.image}
                    <img src="{$post.image}" alt="{$post.title}" width="200"><br>
                {/if}
                <a href="/post/{$post.id}">{$post.title}</a>
                ({$post.published_at}, просмотров: {$post.views})
            </li>
        {/foreach}
    </ul>

    {if $totalPages > 1}
        <p>
            {for $i = 1 to $totalPages}
                {if $i == $page}
                    <b>{$i}</b>
                {else}
                    <a href="?sort={$sort}&page={$i}">{$i}</a>
                {/if}
            {/for}
        </p>
    {/if}
{/block}
