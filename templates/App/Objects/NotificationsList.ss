<% if $ShowNotifications && $NotificationsToday %>
    <div class="notifications-list">
    <% loop $NotificationsToday %>
        <div class="alert alert-warning">
            <div class="alert__container container">
                <% if $DisplayTitle && $Title %>
                    <h2 class="alert__title">$Title</h2>
                <% end_if %>

                <div class="alert__html typography">
                    $Content
                </div>

                <% if $TargetLink %>
                    <% with $TargetLink %>
                        <a
                            class="alert__link" href="$LinkURL"
                            <% if $OpenInNewWindow %> target="_blank"<% end_if %>
                        >
                            $Title
                        </a>
                    <% end_with %>
                <% end_if %>

                <button
                    type="button"
                    class="alert__close btn btn-danger btn-close"
                    data-bs-dismiss="alert" aria-label="Close"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    <% end_loop %>
    </div>
<% end_if %>
