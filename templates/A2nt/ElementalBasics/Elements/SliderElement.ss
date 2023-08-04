<% if $ShowTitle || $Content %>
    <% if $ShowTitle %>
        <h2 class="element__title">$Title</h2>
    <% end_if %>
    <% if $Content %>
        <div class="element__html typography">$Content</div>
    <% end_if %>
<% end_if %>

<% if $SlideShow %>
<div class="element__content<% if $SlidesInRow >1 %> container<% end_if %>">
    <div
        id="Carousel{$ID}"
        class="glide
        <% if $SlidesInRow > 1 %>
            carousel-multislide
        <% end_if %>"
        data-per-view="<% if $SlidesInRow >1 %>{$SlidesInRow}<% else %>1<% end_if %>"
        <% if $SlideShow.count > 1 %>
            <% if $Interval %> data-bs-interval="$Interval"<% end_if %>
            data-bs-indicators="true" data-bs-arrows="true"
        <% end_if %>
    >
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
                <% loop $SlideShow %>
                    <li class="glide__slide">
                        <% include SlideItem %>
                    </li>
                <% end_loop %>
            </ul>
        </div>
    </div>
</div>
<% end_if %>
