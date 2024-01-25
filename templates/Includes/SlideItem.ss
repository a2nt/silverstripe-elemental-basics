<% include SlideItem_media %>

<% if $Content || $Headline || $CustomTitle || $Description %>
<div class="container">
    <div class="carousel-caption">
        <div class="carousel-caption-container">
            <% if $Headline %>
                <h2 class="carousel-title">
                    $Headline
                </h2>
            <% end_if %>

            <% if $Content %>
                <div class="carousel-content">$Content</div>
            <% else_if $Description %>
                <p class="carousel-content">$Description</p>
            <% end_if %>
        </div>
    </div>
</div>
<% end_if %>
