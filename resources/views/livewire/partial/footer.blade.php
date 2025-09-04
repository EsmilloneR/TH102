<div>
    <section *ngIf="showNewsletter" class="bg-gray-300 text-dark-2 p-4 py-6">
        <div class="w-full flex flex-col lg:flex-row justify-center items-center gap-4">
            <div>
                <div class="font-semibold text-xs">NEWSLETTER</div>
                <div class="text-xs text-gray-500">Stay up-to-date</div>
            </div>
            <div class="relative w-full max-w-[400px] px-4 py-3 bg-white text-dark rounded-3xl">
                <input class="w-full text-sm outline-none px-4" placeholder="Enter your email address" />
                <button
                    class="bg-gray-500 rounded-full w-12 h-12 absolute right-0 top-0 bottom-0 flex justify-center items-center">
                    <i class="fa fa-paper-plane text-white"></i>
                </button>
            </div>
        </div>
    </section>
    <footer>
        <div
            class="bg-[#E0E2E6] text-dark-2 pt-5 px-10 lg:pt-10 flex flex-col lg:flex-row justify-evenly items-stretch gap-8 lg:gap-0">
            <div class="px-3 text-center lg:text-left">
                <div class="font-bold text-2xl">Drive & Go</div>
                <div class="text-xs max-w-[240px] mx-auto mb-10 lg:mb-0 text-gray-400">
                    DRIVE&GO covers is a web-based car rental platform with a focus on efficient vehicle reservation,
                    tracking, and rental management features suitable for urban rental businesses. The platform’s
                    tracking
                    functionality will be based on alternative, non-GPS methods to monitor the general status of
                    vehicles,
                    relying on user input or automated updates rather than real-time GPS location.
                </div>
            </div>
            <div class="flex-1 px-3 text-sm flex flex-col justify-start items-center">
                <div class="uppercase font-semibold">COMPANY</div>
                <div class="p-1">About Us</div>
                <div class="p-1">Legal Information</div>
                <div class="p-1">Contact Us</div>
                <div class="p-1">Blogs</div>
            </div>
            <div class="flex-1 px-3 text-sm flex flex-col justify-start items-center">
                <div class="uppercase font-semibold">HELP CENTER</div>
                <div class="p-1">Why Us?</div>
                <div class="p-1">FAQs</div>
                <div class="p-1">Rental Guides</div>
            </div>
            <div class="flex-1 px-3 text-sm flex flex-col justify-start lg:items-start items-center">
                <div class="uppercase font-semibold text-center w-full mb-3 lg:mb-0 lg:w-fit lg:text-left">
                    CONTACT INFO
                </div>
                <div class="py-1">Phone: +63 977 300 5696</div>
                <div class="py-1">Email: cloacalkissed14&#64;yahoo.com</div>
                <div class="py-1">Location: Mangagoy, Bislig City</div>
                <div class="py-1 flex justify-evenly mt-4 mb-8 lg:justify-start gap-2 lg:gap-6 items-center w-full">
                    <div><i class="fab fa-facebook"></i></div>
                    <div><i class="fab fa-twitter"></i></div>
                    <div><i class="fab fa-instagram"></i></div>
                    <div><i class="fab fa-linkedin"></i></div>
                </div>
            </div>
        </div>
        <div class="bg-[#E0E2E6] text-dark-2 text-xs border-gray-300 border-t p-4 text-center">
            &copy; Drive & Go | All rights reserved
        </div>
    </footer>

</div>
