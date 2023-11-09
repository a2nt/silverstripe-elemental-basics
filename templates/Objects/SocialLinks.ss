<div class="sc-links">
    <% if $PhoneNumber %>
        <a href="$PhoneNumber.LinkURL" title="Phone Number" class="pnum">
            <i class="fa-solid fa-phone"></i>
            <i class="visually-hidden">Email</i>
        </a>
    <% end_if %>

    <% if $PublicEmail %>
        <a href="$PublicEmail.LinkURL" title="Email" class="email">
            <i class="fa-solid fa-envelope"></i>
            <i class="visually-hidden">Email</i>
        </a>
    <% end_if %>
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
            <i class="fa-brands fa-x-twitter"></i>
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
