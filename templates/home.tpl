{extends file="layout.tpl"}

{block name=content}
    {foreach $categories as $category}
        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h3 mb-0">{$category.name}</h2>
                <a href="/category/{$category.id}" class="btn btn-outline-primary btn-sm">Все статьи</a>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                {foreach $category.posts as $post}
                    <div class="col">{include file="_post_card.tpl"}</div>
                {/foreach}
            </div>
        </section>
    {foreachelse}
        <p class="text-muted">Статей пока нет</p>
    {/foreach}
{/block}
