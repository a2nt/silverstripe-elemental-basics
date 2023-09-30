<% with $Page %>
    <% if $SideBarContent || $SideBarView && $SideBarView.Widgets.Count %>
        <% if $ShowTitle %>
            <h2 class="element__title">$Title</h2>
        <% end_if %>

        $SideBarContent
        $SideBarView
    <% end_if %>
<% end_with %>
