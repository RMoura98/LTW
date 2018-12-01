<?php

include_once './functions.php';
include_once './tpl.php';
draw_header();
?>

    <aside id="related">
      <article>
        <h1><a href="#">Duis arcu purus</a></h1>
        <p>Etiam mattis convallis orci eu malesuada. Donec odio ex, facilisis ac blandit vel, placerat ut lorem. Ut id sodales purus. Sed ut ex sit amet nisi ultricies malesuada. Phasellus magna diam, molestie nec quam a, suscipit finibus dui. Phasellus a.</p>
      </article>
      <article>
        <h1><a href="#">Sed efficitur interdum</a></h1>
        <p>Integer massa enim, porttitor vitae iaculis id, consequat a tellus. Aliquam sed nibh fringilla, pulvinar neque eu, varius erat. Nam id ornare nunc. Pellentesque varius ipsum vitae lacus ultricies, a dapibus turpis tristique. Sed vehicula tincidunt justo, vitae varius arcu.</p>
      </article>
      <article>
        <h1><a href="#">Vestibulum congue blandit</a></h1>
        <p>Proin lectus felis, fringilla nec magna ut, vestibulum volutpat elit. Suspendisse in quam sed tellus fringilla luctus quis non sem. Aenean varius molestie justo, nec tincidunt massa congue vel. Sed tincidunt interdum laoreet. Vivamus vel odio bibendum, tempus metus vel.</p>
      </article>
    </aside>
    <section id="news">
    <?php
$articles = getAllNews();
foreach ($articles as $article) {?>
        <article>
            <header>
                <h1><a href="item.php?id=<?=$article['id']?>"><?=$article['title']?></a></h1>
            </header>
            <a href="item.php?id=<?=$article['id']?>"><img src=<?=$article['imageUrl']?> alt=""></a>
            <footer>
                <span class="author"><?=$article['username']?></span>
                <span class="likes"><?=$article['upvotes']?></span>
                <span class="dislikes"><?=$article['downvotes']?></span>
                <span class="tags">
                <?php
$fulltags = explode(',', $article['tags']);
    foreach ($fulltags as $tag) {
        echo "<a href='tag.php?id=$tag'>#$tag</a> ";
    }
    ?>
                </span>
                <span class="date"><?=time_ago($article['published'])?></span>
                <a class="comments" href="item.php?id=<?=$article['id']?>#comments"><?=$article['comments']?></a>
            </footer>
        </article>
    <?php }?>
    </section>
    
<?php    draw_footer();
?>