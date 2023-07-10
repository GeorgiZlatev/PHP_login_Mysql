<?php 
            $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);//Прави връзка с ДБ
        $rowCount = mysqli_num_rows($result);//извлича редовете от ДБ
    if ($rowCount > 0){
        //Масив с нова променлива $row извиква реда от колоните в асоциативен масив
        while ($row = mysqli_fetch_assoc($result)){
            //извиква редонете от таблечата, като се изписват имената на колоните
            echo $row['username'].' '.$row['password'].' '. $row['email']."<br>";
        }
    }else {
        echo "No result fount.";
    }
 ?>
 
-------------------------
<?php 

if (isset($_POST['submit'])){
    
        require 'database.php';
        
        $username = $_POST['username'];        
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
//        $email = $_POST['email'];
        
        if (empty($username) || empty($password) || empty($confirmpassword)){
            header("Location: ../register.php?error=emptyfields&username=".$username);
            exit();
        }elseif(!preg_match("/^[a-zA-Z0-9]*/", $username)){
            header("Location: ../register.php?error=invalidusername&username=".$username);
            exit();
        }elseif($password !== $confirmpassword){
            header("Location: ../register.php?error=passwordsdonotmatch&username=".$username);
            exit();            
        } else {
            $sql = "SELECT username FROM users WHERE username = ?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
              header("Location: ../register.php?error=sqlerror");
                exit();              
            }else {
                //s означава стринг, а b boolean. Ако искаме да проверим и пот. име и email трябва да е ss
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);
                //тук проверяваме ако е по голямо от 0 значи имаме съвпадение
                if($rowCount > 0){
                    header("Location: ../register.php?error=passwordsdonotmatch&usernametaken");
                    exit();                   
                }else {
                    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                     if (!mysqli_stmt_prepare($stmt, $sql)){
                      header("Location: ../register.php?error=passwordsdonotmatch&username=sqlerror");
                    exit();                   
                     }else {
                         $hashedPass = password_hash($password, PASSWORD_DEFAULT);
                         //s означава стринг, а b boolean. Ако искаме да проверим и пот. име и email трябва да е ss
                        mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPass);
                        mysqli_stmt_execute($stmt);
                          header("Location: ../register.php?succes=registered");
                        exit();                          
                     }
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    }
 ?>