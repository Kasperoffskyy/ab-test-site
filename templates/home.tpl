{extends file="layout.tpl"}

{block name=content}
    {foreach $categories as $category}
        <h2>{$category.name}</h2>
        <ul>
            {foreach $category.posts as $post}
                <li>
                    {if $post.image}
                        <img src="{$post.image}" alt="{$post.title}" width="200"><br>
                    {/if}
                    <a href="/post/{$post.id}">{$post.title}</a>
                    ({$post.published_at}, просмотров: {$post.views})
                </li>
            {/foreach}
        </ul>
        <a href="/category/{$category.id}">Все статьи</a>
    {foreachelse}
        <p>Статей пока нет</p>
    {/foreach}
{/block}
