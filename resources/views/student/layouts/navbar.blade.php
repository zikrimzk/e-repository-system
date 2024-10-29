 <?php
 use App\Models\Semester;
 
 ?>

 <!-- app-header -->
 <header class="app-header">

     <!-- Start::main-header-container -->
     <div class="main-header-container container-fluid">

         <!-- Start::header-content-left -->
         <div class="header-content-left">
             <div class="header-element">
                 <a aria-label="Hide Sidebar"
                     class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                     data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
             </div>


             <div class="header-element">
                 <div class="d-flex align-items-center">
                     <div class="d-sm-block d-none">
                         <img src="../assets/images/brand-logos/e-Repositorylogoblack.png" alt="logo"
                             width="100px">
                     </div>

                 </div>
             </div>

             <div class="header-element">
                 <div class="d-flex align-items-center">
                     <div class="d-sm-block d-none">
                         <p class="fw-semibold fs-11 mb-0 px-1 text-dark">
                             {{ Semester::where('status', 'Active')->first()->label }}</p>
                     </div>

                 </div>
             </div>



         </div>
         <!-- End::header-content-left -->


         <!-- User element -->
         <div class="header-element">
             <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                 data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                 <div class="d-flex align-items-center">
                     <div class="me-sm-2 me-0">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                             class="bi bi-person-circle" viewBox="0 0 16 16">
                             <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                             <path fill-rule="evenodd"
                                 d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                         </svg>
                     </div>
                     <div class="d-sm-block d-none">
                         <p class="fw-semibold mb-0 text-dark">{{ Auth::user()->name }}</p>
                         <span class="op-7 fw-normal d-block fs-11 text-dark">{{ Auth::user()->email }}</span>
                     </div>
                 </div>
             </a>

             <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                 aria-labelledby="mainHeaderProfile">
                 <li><a class="dropdown-item d-flex" href="{{ route('studentProfile') }}"><i
                             class="ti ti-user-circle fs-18 me-2 op-7"></i>Profile</a></li>
                 <form action="{{ route('student.logout') }}" method="POST">
                     @csrf
                     <li><button type="submit" class="dropdown-item d-flex"><i
                                 class="ti ti-logout fs-18 me-2 op-7"></i>Logout</button></li>
                 </form>
             </ul>
         </div>
         <!-- End User element -->







     </div>
     <!-- End::header-content-right -->

     </div>
     <!-- End::main-header-container -->

 </header>
 <!-- /app-header -->
