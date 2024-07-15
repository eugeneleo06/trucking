    <?php
        require 'navlinks.php';
        $current_page = basename($_SERVER['PHP_SELF']);
    ?>
  
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <?php foreach ($nav_links as $link): ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link <?php echo ($current_page != $link['url']) ? 'collapsed' : ''; ?>" href="<?php echo $link['url']; ?>" >
                    <span><?php echo $link['text']; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
      
      <!-- End Dashboard Nav -->
    </ul>

  </aside><!-- End Sidebar-->