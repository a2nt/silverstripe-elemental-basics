<% with $Page %>
    <% if $SideBarContent || $SideBarView && $SideBarView.Widgets.Count %>
        $SideBarContent
        $SideBarView
    <% end_if %>
<% end_with %>
