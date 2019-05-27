@extends('frontend.layouts.master')
@section('content')
    <!--Banner section start-->
    <div class="cy_bread_wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h1>blog single</h1>
                    </div>
                </div>
            </div>
    </div>
    <!--Blog section start-->
        <div class="cy_blog_wrapper cy_section_padding  cy_blog_page">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <div class="cy_blog_box">
                            <div class="cy_blog_img">
                                <img src="images/blog/blog_single.jpg" alt="blog single" class="img-fluid" />
                                <div class="cy_blog_overlay"></div>
                                <div class="cy_blog_links">
                                    <ul>
                                        <li><a href="#"><i class="fa fa-comments-o" aria-hidden="true"></i> 15</a></li>
                                        <li><a href="#"><i class="fa fa-heart" aria-hidden="true"></i> 120</a></li>
                                        <li><a href="#" class="cy_relative"><i class="fa fa-share-alt" aria-hidden="true"></i> share</a>
                                            <ul class="cy_so_icons">
                                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-tumblr" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cy_blog_data">
                                <ul class="cy_blog_info">
                                    <li><a href="#">by maria</a></li>
                                    <li><a href="#">14 apr, 2018</a></li>
                                    <li><a href="#">cycling</a></li>
                                </ul>
                                <h2><a href="#">Selecting The Proper Bicycle</a></h2>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like.</p>
                                <div class="cy_blockquotes">
                                    <blockquote cite="">
                                        On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain.
                                    </blockquote>
                                </div>
                                <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.</p>
                            </div>
                        </div>
                        <!--comments area start-->
                        <div class="comments-area">
                            <div class="comments-area-title">
                                <h3 class="comments-title"> Comments</h3>
                            </div>
                            <ol class="commentlist">
                                <li class="comment">
                                    <div class="cy_comments">
                                        <div class="comment_img">
                                            <img src="images/blog/author.png" alt="comment author" />
                                        </div>
                                        <div class="comment_data">
                                            <div class="comment_data_info">
                                                <h3><a href="#">lena adms</a></h3>
                                                <p>- Apr 18, 2018 at 10:30pm</p>
                                                <span class="comment-reply"><a href="#"> <i class="fa fa-reply" aria-hidden="true"></i> reply</a></span>
                                            </div>
                                            <p class="comment_para">
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
                                            </p>
                                        </div>
                                    </div>
                                    <ul class="children">
                                        <li class="comment">
                                            <div class="cy_comments">
                                                <div class="comment_img">
                                                    <img src="images/blog/author1.png" alt="comment author" />
                                                </div>
                                                <div class="comment_data">
                                                    <div class="comment_data_info">
                                                        <h3><a href="#">peter nevil</a></h3>
                                                        <p>- Apr 18, 2018 at 10:30pm</p>
                                                        <span class="comment-reply"><a href="#"> <i class="fa fa-reply" aria-hidden="true"></i> reply</a></span>
                                                    </div>
                                                    <p class="comment_para">
                                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                        <!--comments area end-->
                        <div class="comment-respond">
                            <h3 id="reply-title" class="comment-reply-title">leave a comment</h3>
                            <form>
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="comment_input_wrapper">
                                            <input name="name" value="" type="text" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="comment_input_wrapper">
                                            <input name="email" value="" type="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="comment_input_wrapper">
                                            <input name="subject" value="" type="text" placeholder="Subject">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="comment_input_wrapper">
                                            <textarea id="comment" name="comment" placeholder="Comments"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="comment-form-submit">
                                            <input name="submit" type="submit" id="comment-submit" class="submit cy_button" value="Submit">
                                        </div>
                                    </div>
    
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--Sidebar Start-->
                    <div class="col-lg-4 col-md-12">
                        <div class="sidebar cy_sidebar">
                            <!--Search-->
                            <div class="widget widget_search">
                                <form class="search-form">
                                    <div class="input-group">
                                        <input type="text" value="" name="s" class="form-control" placeholder="Search">
                                        <span class="cy_search_btn">
                                            <button class="btn btn-search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <!--Categories-->
                            <div class="widget widget_categories">
                                <h3 class="widget-title">Categories</h3>
                                <ul>
                                    <li><a href="#"> Cycling</a></li>
                                    <li><a href="#"> Biking</a></li>
                                    <li><a href="#"> Rider</a></li>
                                    <li><a href="#"> Sports</a></li>
                                    <li><a href="#"> Life Style</a></li>
                                    <li><a href="#"> Cycling</a></li>
                                    <li><a href="#"> biking</a></li>
                                </ul>
                            </div>
                            <!--Recent Post-->
                            <div class="widget widget_recent_entries">
                                <h3 class="widget-title">Recent Posts</h3>
                                <ul>
                                    <li>
                                        <div class="recent_cmnt_img">
                                            <img src="images/blog/r_post1.jpg" alt="post" />
                                        </div>
                                        <div class="recent_cmnt_data">
                                            <h4><a href="#">Selecting The Proper Bicycle</a></h4>
                                            <span>14 Apr, 2018</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="recent_cmnt_img">
                                            <img src="images/blog/r_post2.jpg" alt="post" />
                                        </div>
                                        <div class="recent_cmnt_data">
                                            <h4><a href="#">Selecting The Proper Bicycle</a></h4>
                                            <span>14 Apr, 2018</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--Tag Cloud-->
                            <div class="widget widget_tag_cloud">
                                <h3 class="widget-title">Tags</h3>
                                <ul>
                                    <li><a href="#">Cycling</a></li>
                                    <li><a href="#">Biking</a></li>
                                    <li><a href="#">Bike</a></li>
                                    <li><a href="#">Mountain</a></li>
                                    <li><a href="#">Sports </a></li>
                                    <li><a href="#">Club </a></li>
                                </ul>
                            </div>
                            <!--Sociallinks-->
                            <div class="widget widget_social_links">
                                <h3 class="widget-title">follow us</h3>
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-vimeo" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection