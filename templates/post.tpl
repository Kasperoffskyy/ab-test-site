{extends file="layout.tpl"}

{block name=title}{$post.title}{/block}

{block name=content}
    <h1>{$post.title}</h1>
    {if $post.image}
        <img src="{$post.image}" alt="{$post.title}">
    {/if}
    <p>
        {$post.published_at}, просмотров: {$post.views}<br>
        Категории:
        {foreach $categories as $category}
            <a href="/category/{$category.id}">{$category.name}</a>{if !$category@last}, {/if}
        {/foreach}
    </p>
    <p><i>{$post.description}</i></p>
    <div>{$post.content|escape|nl2br nofilter}</div>

    {if $similar}
        <h3>Похожие статьи</h3>
        <ul>
            {foreach $similar as $item}
                <li><a href="/post/{$item.id}">{$item.title}</a></li>
            {/foreach}
        </ul>
    {/if}
{/block}
