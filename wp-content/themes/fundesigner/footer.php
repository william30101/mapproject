	
    
    <footer class="footer">
	
    <div id="footer-widgets"><div id="footer-widget1"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-1') ) : ?><?php endif; ?>
</div>

<div id="footer-widget2">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-2') ) : ?>

<?php endif; ?>

</div>

<div id="footer-widget3">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-3') ) : ?>

<?php endif; ?>

</div>

</div>

<div style=“clear-both"></div>
    
    
    	<div class="copyright">Copyright © 2013 <a href="<?php bloginfo("url"); ?>"><?php bloginfo("name"); ?></a></div>
	</footer>
	</div>
	<?php wp_footer(); ?>
</body>
</html>