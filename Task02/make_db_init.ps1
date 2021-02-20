
$db_init_script = './db_init.sql'

$drop_T_Movies = "DROP TABLE IF EXISTS movies;"
$drop_T_Ratings = "DROP TABLE IF EXISTS ratings;"
$drop_T_Tags = "DROP TABLE IF EXISTS tags;"
$drop_T_Users = "DROP TABLE IF EXISTS users;"
$tableMovies = "CREATE TABLE movies (
        id INTEGER PRIMARY KEY,
        title varchar(255),
        year date,
        genres varchar(255));"

$tableRatings = "CREATE TABLE ratings (
        id INTEGER PRIMARY KEY,
        user_id INTEGER,
        movie_id INTEGER,
        rating REAL,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP);"

$tableTags = "CREATE TABLE tags(
        id INTEGER PRIMARY KEY,
        user_id INTEGER,
        movie_id INTEGER,
        tag VARCHAR(50),
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP);"

$tableUsers = "CREATE TABLE users(
        id INTEGER PRIMARY KEY,
        name VARCHAR(30),
        email varchar(255),
        gender varchar(10),
        register_date TEXT,
        occupation varchar(30));"
Add-Content $db_init_script -Value $drop_T_Movies
Add-Content $db_init_script -Value $drop_T_Ratings
Add-Content $db_init_script -Value $drop_T_Tags
Add-Content $db_init_script -Value $drop_T_Users

Add-Content $db_init_script -Value $tableMovies
Add-Content $db_init_script -Value $tableRatings
Add-Content $db_init_script -Value $tableTags
Add-Content $db_init_script -Value $tableUsers
function File1 {
        $Movies_csv = './dataset/movies.csv'
        $Global:str1 = ""
        Import-csv $Movies_csv -Delimiter ','| ForEach-Object{
        $movie_id = $_.'movieId'
        $A = $_.'title'
        $C = $A.Replace("'","''")
        $title = $C.Substring(0, $C.Length - 6)
        $B = $A|Select-String "\d\d\d\d"
        $year = $B.Matches.Value
        $D = $_.'genres'
        $genres = $D.Replace("'","''")
        $str1 += "($movie_id, '$title', '$year', '$genres'),"       
        }
        $str1 = $str1.TrimEnd(",")
        return $str1
        
}
$str1 = (File1)

$insertMovies = "INSERT INTO movies (id, title, year, genres) VALUES $str1;"
Add-Content $db_init_script -Value $insertMovies

function File2 {
        $Ratinds_csv = './dataset/ratings.csv'
        $id = 1
        Import-csv $Ratinds_csv -Delimiter ','|ForEach-Object{   
        $user_id = $_.'userId'
        $movieId = $_.'movieId'
        $rating = $_.'rating'
        $timestamp = $_.'timestamp'
        if ($user_id -le 50){$str2 += "($id, $user_id, $movieId, $rating, $timestamp),"}
        else{
                $str22+="($id, $user_id, $movieId, $rating, $timestamp),"
        }
               
        $id++
        }
        $str2 = $str2.TrimEnd(",")
        $str22 = $str22.TrimEnd(",")
        return $str2, $str22
}
$str2 = (File2)
$a1 = $str2[0]
$insertRatings = "INSERT INTO ratings (id, user_id, movie_id, rating, timestamp) VALUES $a1;"
$a2 = $str2[1]
$insertRatings1 = "INSERT INTO ratings (id, user_id, movie_id, rating, timestamp) VALUES $a2;"
Add-Content $db_init_script -Value $insertRatings
Add-Content $db_init_script -Value $insertRatings1

function File3 {
        $Tags_csv = './dataset/tags.csv'
        $id = 1
        Import-csv $Tags_csv -Delimiter ','|ForEach-Object{
        
        $user_id = $_.'userId'
        $movieId = $_.'movieId'
        $A = $_.'tag'
        $tag = $A.Replace("'","''")
        $timestamp = $_.'timestamp'
        $str3 +="($id, $user_id, $movieId, '$tag', $timestamp),"   
        $id++
        }
        $str3 = $str3.TrimEnd(",")
        return $str3
        
}
$str3 = (File3)

$insertTags = "INSERT INTO tags (id, user_id, movie_id, tag, timestamp) VALUES $str3;"
Add-Content $db_init_script -Value $insertTags


function File4 {
        $Users_txt = Get-Content -Path './dataset/users.txt'
        foreach($c in $Users_txt){
        $c = $c.Replace("'","''")
        $a = $c.Split("|")
        $id = $a[0]
        $user_name = $a[1]
        $email = $a[2]
        $gender = $a[3]
        $register_date = $a[4]
        $occupation = $a[5]
        $str4 +="($id, '$user_name', '$email', '$gender', '$register_date', '$occupation'),"     
        }    
        $str4 = $str4.TrimEnd(",")
        return $str4
}

$str4 = (File4)

$insertUsers = "INSERT INTO users (id, name, email, gender, register_date, occupation) VALUES $str4;"
Add-Content $db_init_script -Value $insertUsers



