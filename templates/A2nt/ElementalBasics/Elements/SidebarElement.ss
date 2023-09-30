<% with $Page %>
    <% if $SideBarContent || $SideBarView && $SideBarView.Widgets.Count %>
        <% if $Up.ShowTitle %>
            <h2 class="element__title">$Up.Title</h2>
        <% end_if %>
        <div class="sidebar-content">
            $SideBarContent
            $SideBarView
        </div>
    <% end_if %>
<% end_with %>
