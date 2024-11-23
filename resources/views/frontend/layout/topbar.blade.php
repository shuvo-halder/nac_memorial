 <div class="top-bar d-none d-md-block">
     <div class="container">
         <div class="row align-items-center">
             <!-- Desktop View -->
             <div class="col-12 d-none d-md-flex justify-content-between">
                 <span class="">
                     <i class="fas fa-users"></i> Registrations: <strong
                         id="registrations-count">{{ $totalUser }}</strong>
                 </span>
                 <span class="">
                     <i class="fas fa-book"></i> Memorials: <strong id="memorials-count">{{ $totalMemorial }}</strong>
                 </span>
                 <span class="">
                     <i class="fas fa-comments"></i> Memorial Comments: <strong
                         id="memorial-comments-count">{{ $totalMemorialComment }}</strong>
                 </span>
                 <span class="">
                     <i class="fas fa-newspaper"></i> Blog Articles: <strong
                         id="blog-articles-count">{{ $totalBlog }}</strong>
                 </span>
                 <span class="">
                     <i class="fas fa-comment-dots"></i> Blog Comments: <strong
                         id="blog-comments-count">{{ $totalBlogComment }}</strong>
                 </span>
             </div>

             <!-- Mobile View -->
             <div class="col-12 d-flex d-md-none justify-content-between">
                 <span class="">
                     <i class="fas fa-book"></i> Memorials: <strong
                         id="memorials-count-mobile">{{ $totalMemorial }}</strong>
                 </span>
                 <span class="">
                     <i class="fas fa-comments"></i> Comments: <strong
                         id="memorial-comments-count-mobile">{{ $totalMemorialComment }}</strong>
                 </span>
             </div>
         </div>
     </div>
 </div>
