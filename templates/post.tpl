{extends file="layout.tpl"}

{block name=title}{$post.title}{/block}

{block name=content}
    <article class="bg-white p-4 rounded shadow-sm mb-5">
        <h1>{$post.title}</h1>

        <div class="text-muted small mb-3">
            {$post.published_at|date_format:"%d.%m.%Y"} · Просмотров: {$post.views}
        </div>

        <div class="mb-3">
            {foreach $categories as $category}
                <a href="/category/{$category.id}" class="badge text-bg-primary text-decoration-none">{$category.name}</a>
            {/foreach}
        </div>

        {if $post.image}
            <img src="{$post.image}" class="img-fluid rounded mb-4" alt="{$post.title}">
        {/if}

        <p class="lead">{$post.description}</p>
        <div>{$post.content|escape|nl2br nofilter}</div>
    </article>

    {if $similar}
        <h2 class="h4 mb-3">Похожие статьи</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            {foreach $similar as $post}
                <div class="col">{include file="_post_card.tpl"}</div>
            {/foreach}
        </div>
    {/if}
{/block}
