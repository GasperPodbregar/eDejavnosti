        <footer class="footer mt-auto py-3">
            <div class="container-fluid">
                <p class="footerText">Avtorja: Nik Jukič, Gašper Podbregar</p>
            </div>
        </footer>
        
        <script>
            
            init_pointer({
                pointerColor: "black",
                ringSize: 15,
                ringClickSize: 10 
            })
            function openNav() {
              document.getElementById("mySidenav").style.width = "250px";
            }
            function closeNav() {
              document.getElementById("mySidenav").style.width = "0";
            }
            function hideMessage() {
                document.getElementById("goaway").style.display = "none";
            };
            setTimeout(hideMessage, 10000);
        </script>

    </body>
    
</html>