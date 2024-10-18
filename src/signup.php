<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management Sytem</title>
    <link rel="stylesheet" href="\Main Project\Barangay-Management-System\src\style.css">
    <script src="\Main Project\Barangay-Management-System\tailwind.config.js"></script>
</head>
<body  class="absolute inset-0 h-full w-full bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
    <div class="bg-white grid grid-rows-2/5 grid-cols-1 rounded-xl w-full bg-white bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
        <div class="text-5xl place-self-center w-full pt-12 col-span-3 rounded-xl mb-16" >
            <h1 class="bg-pg p-6 text-center font-bold shadow-xl " >Barangay Management System</h1>
        </div>
        <div class="rounded-xl grid ml-96 st:ml-0"  >
            <div class="bg-pg rounded-xl grid place-self-center shadow-2xl st:ml-0">
                <div class="grid rounded-xl bg-c m-10 mb-0 p-14 shadow-lg">
                    <div class="grid grid-rows-2 mb-2">
                        <p class="text-3xl font-bold break-after-auto">Create Account</p>
                        <p >Get started with an account.</p>
                    </div>
                    <form action="#" ">
                        <div class="grid grid-rows-3 grid-cols-2 ">
                            <!--1,4,2,5,3 -->
                            <div>
                                <input type="text" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Email Address</label>
                            </div>
                            <div>
                                <input type="password" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c ml-2" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-4 peer-focus:scale-75 peer-focus:translate-x-2 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Password</label>
                            </div>
                            <div>
                                <input type="numer" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Username</label>
                            </div>
                            <div>
                                <input type="password" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c ml-2" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-4 peer-focus:scale-75 peer-focus:translate-x-2 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Re-type Password</label>
                            </div>
                            <div>
                                <input type="numer" class="block bg-transparent w-72 border-2 border-sg text-m p-2 peer rounded-md focus:outline-none focus:ring-0 focus:border-bg-c" placeholder=" "/> 
                                <label class="absolute text-sg pointer-events-none text-sm duration-300  transform -translate-y-13.5 -translate-x-1 pl-2 pr-2 scale-75 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-8 peer-placeholder-shown:translate-x-2 peer-focus:scale-75 peer-focus:-translate-x-1 peer-focus:-translate-y-13.5 z-10 bg-c pl-1 text-left rounded-2xl ">Contact Information</label>
                            </div>
                            <div class="grid grid-cols-1 place-self-end">
                                <button class="rounded-md bg-pg w-full p-2 pl-4 pr-4 text-l col-span-2">Sign In</button><br>
                               <a href="#" class="underline text-blue-700 text-s">Forgot Password?</a>
                            </div>
                        </div>

                      
                     </form>
                </div>
                <p class="text-center rounded-xl mb-28 mt-4 text-s md:mb-12">Already have an account? <a href="#" class="underline text-blue-700">Sign In</a></p>
            </div>
        </div>    
    </div>
</body>
</html>