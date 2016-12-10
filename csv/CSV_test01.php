<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Examples</title>
<meta name="description" content="">
<meta name="keywords" content="">
<link href="" rel="stylesheet">
<script src="jquery-3.1.0.min.js"></script>
<script src="jquery-csv.js"></script>

</head>
<body>
    <div class="menu">
        <select id="S_person" onchange="change_person()">
            <option value="all">全部</option>
        </select>

        <select id="S_year" onchange="change_year()">
            <option value="all">全部</option>
        </select>

        <select id="S_month" onchange="change_month()">
            <option value="all">全部</option>
        </select>

        <select id="S_city" onchange="change_city()">
            <option value="all">全部</option>
        </select>

        <select id="S_town" onchange="change_town()">
            <option value="all">全部</option>
        </select>

        <select id="S_loc" onchange="change_loc()">
            <option value="all">全部</option>
        </select>

        <select id="S_family" onchange="change_family()">
            <option value="all">全部</option>
        </select>

        <select id="S_genus" onchange="change_genus()">
            <option value="all">全部</option>
        </select>
   
        <select id="S_species" onchange="change_species()">
            <option value="all">全部</option>
        </select>

        <button onclick="submit();">送出</button>
    </div>

    <div id="demo"></div>

<script>

    var csv = {

        Contents:"Null",

        init: function () {
            $.ajax({
                url: "mothdatabase.txt", // txt 要另存新檔, 選擇 utf-8 編碼才不會亂碼
                async: false,
                scriptCharset: 'utf-8',
                contentType: "application/x-www-form-urlencoded;charset=utf-8",
                success: function (data){
                    csv.Contents = data;
                }
            });
        }
    };

    csv.init();



    // 將所有文字合併, 用逗點或斷行分開, 放進陣列
    csv.Contents = Array.from(csv.Contents).join('').split(/,|\n/);

    //轉成二維陣列
    var arr=[], len=csv.Contents.length, rows=Math.ceil(len/14);
    for(let i=0; i<rows; i++){
        arr[i]=csv.Contents.slice( i*14, (i+1)*14 );
    }
//==========================================================================

    function create_options(type, type_id){
        for(let i=0; i < type.length; i++){
            var ops = document.createElement('option');
            ops.value = type[i];
            ops.innerHTML = type[i];
            document.getElementById(type_id).appendChild(ops);
        }
    }

    function create_norepeat_arr(i, sort_num){
        let v;
        v=arr.map(cv=>cv[i]);
        v.shift(); v.pop();
        v = sort_num ? Array.from(new Set(v)).sort((a,b)=>b-a) : Array.from(new Set(v)).sort();
        return v;
    }

    //取得不重複的 提供者
    var person = create_norepeat_arr(0, false);
    create_options(person, 'S_person');

    //取得不重複的 年
    var year = create_norepeat_arr(1, true);
    create_options(year, 'S_year');

    //取得不重複的 月
    var month = create_norepeat_arr(2, true);
    create_options(month, 'S_month');

    //取得不重複的 縣市
    var city = create_norepeat_arr(4, false);
    create_options(city, 'S_city');

    //鄉鎮
    var town = [];
    var town_unique = create_norepeat_arr(5, false);

    //地點
    var loc = [];
    var loc_unique = create_norepeat_arr(6, false);

    //取得不重複的 科名
    var family = create_norepeat_arr(9, false);
    create_options(family, 'S_family');

    //屬名
    var genus = [];
    var genus_unique = create_norepeat_arr(10, false);

    //學名
    var species = [];
    var species_unique = create_norepeat_arr(11, false);

//==========================================================================
    var search_p  = 'all';
    var search_y  = 'all';
    var search_m  = 'all';
    var search_ct = 'all';
    var search_tn = 'all';
    var search_lc = 'all';
    var search_fa = 'all';
    var search_ge = 'all';
    var search_sp = 'all';
    var demo = document.getElementById("demo");

    function change_person(){
        search_p  = document.getElementById("S_person").value;
    }

    function change_year(){
        search_y  = document.getElementById("S_year").value;
    }

    function change_month(){
        search_m  = document.getElementById("S_month").value;
    }

    function change_city(){
        search_ct = document.getElementById("S_city").value;

        //刪除 town 選單 (除了全部)
        town = [];
        let elements = document.getElementsByClassName('op_town');
        while(elements.length > 0){
            elements[0].parentNode.removeChild(elements[0]);
        }
        //刪除 loc 選單 (除了全部)
        loc = [];
        let eles = document.getElementsByClassName('op_loc');
        while(eles.length > 0){
            eles[0].parentNode.removeChild(eles[0]);
        }

        //製作 town 選單
        if(search_ct !== 'all'){
            for(let i=0; i < arr.length; i++){
                if(arr[i][4]===search_ct){
                    town.push(arr[i][5]);
                }
            }
            town = Array.from(new Set(town)).sort();

            for(let i=0; i < town.length; i++){
                var ops = document.createElement('option');
                ops.value = town[i];
                ops.innerHTML = town[i];
                ops.className += 'op_town';
                document.getElementById('S_town').appendChild(ops);
            }
        }else if(search_ct === 'all'){
            search_tn = 'all';
            search_lc = 'all';
        }      
    }

    function change_town(){
        search_tn = document.getElementById("S_town").value;

        //刪除 loc 選單 (除了全部)
        loc = [];
        let eles = document.getElementsByClassName('op_loc');
        while(eles.length > 0){
            eles[0].parentNode.removeChild(eles[0]);
        }

        //製作 loc 選單
        if(search_tn !== 'all'){
            for(let i=0; i < arr.length; i++){
                if(arr[i][5]===search_tn){
                    loc.push(arr[i][6]);
                }
            }
            loc = Array.from(new Set(loc)).sort();

            for(let i=0; i < loc.length; i++){
                var ops = document.createElement('option');
                ops.value = loc[i];
                ops.innerHTML = loc[i];
                ops.className = 'op_loc';
                document.getElementById('S_loc').appendChild(ops);
            }
        }         
    }

    function change_loc(){
        search_lc = document.getElementById("S_loc").value;
    }

    function change_family(){
        search_fa = document.getElementById("S_family").value;

        //刪除 genus 選單 (除了全部)
        genus = [];
        let elements = document.getElementsByClassName('op_genus');
        while(elements.length > 0){
            elements[0].parentNode.removeChild(elements[0]);
        }
        //刪除 species 選單 (除了全部)
        species = [];
        let eles = document.getElementsByClassName('op_species');
        while(eles.length > 0){
            eles[0].parentNode.removeChild(eles[0]);
        }

        //製作 genus 選單
        if(search_fa !== 'all'){
            for(let i=0; i < arr.length; i++){
                if(arr[i][9]===search_fa){
                    genus.push(arr[i][10]);
                }
            }
            genus = Array.from(new Set(genus)).sort();

            for(let i=0; i < genus.length; i++){
                var ops = document.createElement('option');
                ops.value = genus[i];
                ops.innerHTML = genus[i];
                ops.className += 'op_genus';
                document.getElementById('S_genus').appendChild(ops);
            }
        }else if(search_fa === 'all'){
            search_ge = 'all';
            search_sp = 'all';
        }      
    }

    function change_genus(){
        search_ge = document.getElementById("S_genus").value;

        //刪除 species 選單 (除了全部)
        species = [];
        let eles = document.getElementsByClassName('op_species');
        while(eles.length > 0){
            eles[0].parentNode.removeChild(eles[0]);
        }

        //製作 species 選單
        if(search_ge !== 'all'){
            for(let i=0; i < arr.length; i++){
                if(arr[i][10]===search_ge){
                    species.push(arr[i][11]);
                }
            }
            species = Array.from(new Set(species)).sort();

            for(let i=0; i < species.length; i++){
                var ops = document.createElement('option');
                ops.value = species[i];
                ops.innerHTML = species[i];
                ops.className = 'op_species';
                document.getElementById('S_species').appendChild(ops);
            }
        }         
    }

    function change_species(){
        search_sp = document.getElementById("S_species").value;
    }

    function submit(){
        let search_arr;
        let loop = [search_p, search_y, search_m, search_ct, search_tn, search_lc, search_fa, search_ge, search_sp];
        let unique = [person, year, month, city, town, loc, family, genus, species];
        let unique_alter = [ , , , , town_unique, loc_unique, , genus_unique, species_unique];
        let hip = [0,1,2,4,5,6,9,10,11];

        search_arr = arr.filter(function(cv,i){
            let keep=true;
            for(let i=0; i < loop.length; i++){
                if(loop[i] === 'all'){
                    //在 person 裡面沒有 search_p, 就不保留
                    if(unique[i].length===0){
                        if(unique_alter[i].indexOf( cv[hip[i]] )===-1) keep=false;
                    }else if( unique[i].indexOf( cv[hip[i]] )===-1 ){
                        keep=false;
                    }
                }else{
                    //cv[i] 這筆資料和 search_p 不相等, 就不保留
                    if( cv[hip[i]]!==loop[i] ) keep=false;
                }
            }
            return keep;            
        });


        demo.innerHTML = search_arr;
    }    


// console.log(arr[0]);
// console.log(arr[1]);
// console.log(arr[2]);
// console.log(arr[3]);
// console.log(arr[4]);
// console.log(arr[5]);
// console.log(arr[6]);
// console.log(arr[7]);
// console.log(arr[8]);
// console.log(arr[9]);
console.log(arr.length);
// console.log(arr);
// console.log(csv.Contents[0]);
// console.log(csv.Contents[1]);
// console.log(csv.Contents[2]);
// console.log(csv.Contents[3]);
// console.log(csv.Contents[4]);
// console.log(csv.Contents[5]);
// console.log(csv.Contents[6]);
// console.log(csv.Contents[7]);
// console.log(csv.Contents[8]);
// console.log(csv.Contents[9]);
// console.log(csv.Contents.length);
// console.log(csv.Contents);


</script>

</body>
</html>