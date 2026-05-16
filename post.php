<?php 
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
include "includes/header.php"
?> 
    <!-- Start Process Area -->
      	<div class="relative bg-secondary text-white bg-cover bg-clip-padding w-full sm:pb-0 after:absolute after:inset-0 bg-page-heading-pattern">
        <div class="container relative py-10 sm:py-16">
            <div class="border-l-4 border-primary pl-5 text-left max-w-4xl ">
                <h1 class="text-white  text-3xl sm:text-4xl lg:text-4xl font-extrabold dark:text-white">News Post</h1>
                            </div>
        </div>
    </div>
      <!-- Start Breadcrumb -->
 <style>
/* Pagination container */
.pagination-area {
  margin-top: 20px;
  text-align: center;
}

/* Pagination links */
.page-numbers {
  display: inline-block;
  padding: 5px 10px;
  margin: 0 5px;
  color: #333;
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 3px;
  transition: background-color 0.3s ease;
}

/* Current page link */
.page-numbers.current {
  font-weight: bold;
  background-color: #FE02EC;
  color: #fff;
}

/* Hover effect */
.page-numbers:hover {
  background-color: #FE02EC;
  color: #fff;
}

/* Glowing effect */
.page-numbers.glow {
  animation: glowing 1.5s infinite;
}

@keyframes glowing {
  0% {
    box-shadow: 0 0 5px #FE02EC;
  }
  50% {
    box-shadow: 0 0 20px #FE02EC;
  }
  100% {
    box-shadow: 0 0 5px #FE02EC;
  }
}

</style>
<main>
    <section class="py-14">
    <div class="container">
        <h2 class="font-semibold text-2xl mb-4"></h2>
        <div class="grid grid-cols-1 lg:grid-cols-3 lg:divide-x gap-4">
            <div class="lg:col-span-2">
                <div>
                    <?php
                    // Get the current page number
                    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                    // Set the number of sponsored posts to display per page
                    $posts_per_page = 2;

                    // Calculate the starting row number
                    $start = ($page - 1) * $posts_per_page;

                    $sql = "SELECT * FROM posts ORDER BY created_at DESC LIMIT $start, $posts_per_page";
                    $result = mysqli_query($link, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // Display the sponsored posts
                        $count = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $post_id = $row["post_id"];
                            $title = $row["title"];
                            $content = $row["content"];
                            $image = $row["image"];
                            $author_id = $row["author_id"];
                            $created_at = $row['created_at'];
                    ?>
                            <div class="group relative p-2 sm:p-4 rounded-3xll bg-white dark:bg-transparent dark:hover:bg-gray-800 shadow-2xl shadow-transparent hover:shadow-gray-600/10 gap-2 sm:gap-8 flex transition duration-300">
                                <div>
                                    <img src="/dash/img/posts/<?php echo $row['image']; ?>" alt="" loading="lazy" class="w-20 h-auto lg:w-44 transition duration-500">
                                </div>
                                <div class="w-full space-y-2 lg:space-y-3">
                                    <h3 class="text-sm lg:text-xl font-bold text-gray-800 hover:text-primary dark:text-white line-clamp-2">
                                        <a href="postview?post_id=<?php echo $row['post_id']; ?>"><?php echo $row['title']; ?></a>
                                    </h3>
                                    <p class="text-sm font-serif line-clamp-3"><?php echo $row['content']; ?></p>
                                    <p class="text-gray-600 dark:text-gray-300 text-xs lg:text-sm italic w-full">
                                        Published on <span class=""><?php echo $row['created_at']; ?></span>
                                    </p>
                                </div>
                            </div>
                    <?php
                            $count++;
                        }
                    }
                    ?>
                </div>

                <?php
                // Calculate the total number of pages
                $sql = "SELECT COUNT(*) AS count FROM posts";
                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_assoc($result);
                $total_posts = $row['count'];
                $total_pages = ceil($total_posts / $posts_per_page);
                ?>

                <!-- Display the pagination links -->
                <div class="py-4">
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                        <div class="flex justify-between flex-1 sm:hidden">
                            <?php if ($page > 1) : ?>
                                <a href="?page=<?php echo $page - 1; ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    « Previous
                                </a>
                            <?php else : ?>
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                    « Previous
                                </span>
                            <?php endif; ?>

                            <?php if ($page < $total_pages) : ?>
                                <a href="?page=<?php echo $page + 1; ?>" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                    Next »
                                </a>
                            <?php else : ?>
                                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                    Next »
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5">
                                    Showing
                                    <span class="font-medium"><?php echo $start + 1; ?></span>
                                    to
                                    <span class="font-medium"><?php echo min($start + $posts_per_page, $total_posts); ?></span>
                                    of
                                    <span class="font-medium"><?php echo $total_posts; ?></span>
                                    results
                                </p>
                            </div>
                            <div>
                                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                        <?php if ($i == $page) : ?>
                                            <span aria-current="page" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5"> <?php echo $i; ?> </span>
                                        <?php else : ?>
                                            <a href="?page=<?php echo $i; ?>" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"> <?php echo $i; ?> </a>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </span>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

 
 
 
 
 
   <?php include "includes/footer.php" ?>