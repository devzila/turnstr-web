<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

       <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li><a href="{{url('/admin/users')}}"><span>Users</span></a></li>
            <li><a href="{{url('/admin/posts')}}"><span>Turns</span></a></li>
            <li><a href="{{url('/admin/comments')}}"><span>Comments</span></a></li>
			<li class="treeview">
                <a href="#"><span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/admin/settings/profane')}}">Manage Profane</a></li>
                </ul>
            </li>
            <!--
            <li class="treeview">
                <a href="#"><span>Activity</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/admin/users')}}">Users</a></li>
                    <li><a href="{{url('/admin/posts')}}">Posts</a></li>
                    <li><a href="{{url('/admin/comments')}}">Comments</a></li>
                </ul>
            </li>
            -->
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>