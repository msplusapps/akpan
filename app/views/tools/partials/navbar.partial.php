 <!-- Navigation -->
 <nav class="gradient-bg text-white fixed w-full z-50 shadow-lg">
     <div class="container mx-auto px-6 py-4">
         <div class="flex items-center justify-between">
             <a href="./" class="flex items-center">
                 <i class="fas fa-code text-2xl mr-2"></i>
                 <span class="font-bold text-xl">Akpan MVC</span>
             </a>
             <div class="hidden md:flex space-x-8">
                 <a href="./features" class="nav-link">Features</a>
                 <a href="./documentation" class="nav-link">Documentation</a>
                 <a href="./community" class="nav-link">Community</a>
                 <a href="./download" class="nav-link">Download</a>
                 <a href="./about" class="nav-link">About Us</a>
                 <a href="./contact" class="nav-link">Contact Us</a>
             </div>
             <div class="md:hidden">
                 <button id="menu-btn" class="text-white focus:outline-none">
                     <i class="fas fa-bars text-2xl"></i>
                 </button>
             </div>
         </div>
         <!-- Mobile menu -->
         <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
             <a href="#features" class="block py-2">Features</a>
             <a href="#docs" class="block py-2">Documentation</a>
             <a href="#community" class="block py-2">Community</a>
             <a href="#download" class="block py-2">Download</a>
         </div>
     </div>
 </nav>