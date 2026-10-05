{extends file="layout.tpl"}

{block name=content}
    {foreach $categories as $category}
        <h2>{$category.name}</h2>
        <ul>
            {foreach $category.posts as $post}
                <li><a href="/post/{$post.id}">{$post.title}</a> ({$post.published_at})</li>
            {/foreach}
        </ul>
        <a href="/category/{$category.id}">Все статьи</a>
    {foreachelse}
        <p>Статей пока нет</p>
    {/foreach}
{/block}
