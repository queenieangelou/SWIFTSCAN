<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/home.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    
<section class="header">
    <nav>
        <a href="home.php"><img src="../pictures/logo.png"></a>
        <img src="../pictures/univ_logoo.png"> 
        <div class="nav-links" id="navLinks"> 
            <i class="far fa-window-close" onclick="hideMenu()"></i>
            
            <ul>
                <li><a href="#SwiftScan">SwiftScan</a></li>
                <li><a href="#Facilities">Facilities</a></li>
                <li><a href="#Developers">Developers</a></li>
                <li><a href="#Footer">About Us</a></li>
                <li><a href="../student/student.php">QR Code</a></li>
                <li><a href="../home/facultylogin.php">Login</a></li>
            </ul>                
        </div>
        <i class="fas fa-bars" onclick="showMenu()"></i>
    </nav>

    <div class="textbox">
        <h1 id="SwiftScan">SwiftScan</h1>
        <p>Advancing Attendance Data Efficiency with QR Codes at Batangas State University - The National Engineering University - Lipa Campus
        </p>
        <div class="row">
            <div class="coll">
                <p>By adopting the SwiftScan system, Batangas State University - The National Engineering University - Lipa Campus can advance attendance efficiency and provide a more conducive learning environment. This innovative approach embraces the ongoing digital transformation in education. Subsequent chapters of this study will delve into the feasibility and effectiveness of SwiftScan as a solution to the existing attendance-related challenges.</p>
            </div>
    
            <div class="coll">
                <img src="../pictures/bg.jpg">
                <p> </p>
            </div>
        </div>
    </div>
</section>


<section class="facilities">
    <h1 id = "Facilities"> Our Facilities </h1>
    <p>
        Take a peek at our Classroom Laboratories!
    </p>

    <div class="row">
        <div class="col">
            <img src="../pictures/bg_aest.jpg">
            <h3>Chemical Laboratory</h3>
            <p> See what's in our laboratories </p>
        </div>

        <div class="col">
            <img src="../pictures/bg_aest.jpg">
            <h3>Physics Laboratory</h3>
            <p> See what's in our laboratories </p>
        </div>

        <div class="col">
            <img src="../pictures/bg_aest.jpg">
            <h3>Computer Laboratory</h3>
            <p> See what's in our laboratories </p>
        </div>
    </div>
</section>




<section class="developers">
    <h1 id="Developers"> The Developers </h1>
    <p> BSIT STUDENTS from the BatStateU TNEU Lipa Campus</p>

    <div class="row">
        <div class="dev-col">
            <img src="..\pictures\maria.jpg" alt="Developer 1">
            <div>
                <h3>Maria Andrea De Leon</h3>
                <p>BSIT BA 3102</p>
            </div>
        </div>

        <div class="dev-col">
            <img src="..\pictures\simone.png" alt="Developer 2">
            <div>
                <h3>Simone Louis De Villa</h3>
                <p>BSIT BA 3102</p>
            </div>
        </div>

        <div class="dev-col">
            <img src="..\pictures\irish.jpg" alt="Developer 3">
            <div>
                <h3>Irish Lean Suarez</h3>
                <p>BSIT BA 3102</p>
            </div>
        </div>

        <div class="dev-col">
            <img src="..\pictures\queenie.png" alt="Developer 4">
            <div>
                <h3>Queenie Angelou Manigbas</h3>
                <p>BSIT BA 3102</p>
            </div>
        </div>

        <div class="dev-col">
            <img src="..\pictures\mau.jpg" alt="Developer 5">
            <div>
                <h3>Maureen Lozares</h3>
                <p>BSIT BA 3102</p>
            </div>
        </div>
    </div>
</section>




<section class="footer">
    <h4 id="Footer">About Us</h4>
    <p>
        You can contact us through the links below
    </p>

    <div class="icons">
        <i class="fab fa-facebook"></i>
        <i class="fab fa-twitter"></i>
        <i class="fab fa-instagram"></i>
        <i class="fab fa-linkedin"></i>
    </div>

    <p>Made With <i class="far fa-heart"></i> Queenie, Maureen, Maria, Simone and Irish</p>
</section>

<script>
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>

</body>
</html>
