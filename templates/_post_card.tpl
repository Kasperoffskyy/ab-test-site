<div class="card h-100 shadow-sm">
    {if $post.image}
        <img src="{$post.image}" class="card-img-top" alt="{$post.title}">
    {/if}
    <div class="card-body">
        <h5 class="card-title">
            <a href="/post/{$post.id}" class="stretched-link text-decoration-none text-dark">{$post.title}</a>
        </h5>
        <p class="card-text text-muted small">{$post.description}</p>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between small text-muted">
        <span>{$post.published_at|date_format:"%d.%m.%Y"}</span>
        <span>Просмотров: {$post.views}</span>
    </div>
</div>
