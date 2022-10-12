<div class="sc-links">
    <% if $Facebook %>
        <a href="$Facebook.LinkURL" title="Facebook" class="fb" rel="noreferrer" target="_blank">
            <i class="fab fa-facebook-f"></i>
            <i class="visually-hidden">Facebook</i>
        </a>
    <% end_if %>
    <% if $LinkedIn %>
        <a href="$LinkedIn.LinkURL" title="LinkedIn" class="li" rel="noreferrer" target="_blank">
            <i class="fab fa-linkedin-in"></i>
            <i class="visually-hidden">LinkedIn</i>
        </a>
    <% end_if %>
    <% if $Pinterest %>
        <a href="$Pinterest.LinkURL" title="Pinterest" class="pr" rel="noreferrer" target="_blank">
            <i class="fab fa-pinterest-p"></i>
            <i class="visually-hidden">Pinterest</i>
        </a>
    <% end_if %>
    <% if $Instagram %>
        <a href="$Instagram.LinkURL" title="Instagram" class="in" rel="noreferrer" target="_blank">
            <i class="fab fa-instagram"></i>
            <i class="visually-hidden">Instagram</i>
        </a>
    <% end_if %>
    <% if $Twitter %>
        <a href="$Twitter.LinkURL" title="Twitter" class="tw" rel="noreferrer" target="_blank">
            <i class="fab fa-twitter"></i>
            <i class="visually-hidden">Twitter</i>
        </a>
    <% end_if %>
    <% if $Youtube %>
        <a href="$Youtube.LinkURL" title="YouTube" class="yt" rel="noreferrer" target="_blank">
            <i class="fab fa-youtube"></i>
            <i class="visually-hidden">YouTube</i>
        </a>
    <% end_if %>

    <% if $Tiktok %>
        <a href="$Tiktok.LinkURL" target="_blank">
            <i class="fab fa-tiktok"></i>
            <i class="sr-only">Tiktok</i>
        </a>
    <% end_if %>
</div>
