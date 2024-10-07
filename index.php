<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->

<div id="calendar">
<legend>日付選択</legend>
        <div id="header">
            <button id="prev">&lt;</button>
            <h2 id="monthYear"></h2>
            <button id="next">&gt;</button>
        </div>
        <div id="days"></div>
    </div>
    
<!-- Main[End] -->

<div id="status" class="tick"></div>
  <div class="jumbotron">
   <fieldset>
    <legend>座席選択</legend>
    <select name="text" type="text" id="seki_syubetu">
<option value="バックネット席">バックネット席</option>
<option value="一塁ベンチ上席">一塁ベンチ上席</option>
<option value="三塁ベンチ上席">三塁ベンチ上席</option>
<option value="一塁アルプス席">一塁アルプス席</option>
<option value="三塁アルプス席">三塁アルプス席</option>
<option value="レフトスタンド席">レフトスタンド席</option>
<option value="ライトスタンド席">ライトスタンド席</option>
<option value="ビジター席">ビジター席</option>
</select>
     <button id="btn">送信</button>
    </fieldset>
  </div>



<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>

const monthNames = ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"];
let currentDate = new Date();
let selectedDay = null; // 選択された日付を保持する変数

function renderCalendar() {
    const monthYearElement = document.getElementById("monthYear");
    const daysElement = document.getElementById("days");

    // 月と年の表示
    monthYearElement.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

    // 日付のクリア
    daysElement.innerHTML = "";

    // 月の初日を取得
    const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
    
    // 先月の残りの日を埋める
    for (let i = 0; i < firstDay.getDay(); i++) {
        daysElement.innerHTML += '<div class="day"></div>';
    }

    // 今月の日を埋める
    for (let day = 1; day <= lastDay.getDate(); day++) {
        const dayDiv = document.createElement('div');
        dayDiv.className = 'day';
        dayDiv.textContent = day;

        // 日付クリック時のイベントリスナーを追加
        dayDiv.addEventListener('click', () => {
            if (selectedDay) {
                // 以前に選択されていた日付の色を元に戻す
                selectedDay.classList.remove('selected');
            }

            // 新しい日付を選択し、色を付ける
            selectedDay = dayDiv;
            selectedDay.classList.add('selected');

            const year = currentDate.getFullYear();
            const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // 月を0埋め
            const selectedDate = String(day).padStart(2, '0'); // 日を0埋め

            // yyyy/mm/dd形式で表示
            const formattedDate = `${year}/${month}/${selectedDate}`;
        });

        daysElement.appendChild(dayDiv);
    }
}

// 前月、翌月ボタンのイベント
document.getElementById("prev").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

document.getElementById("next").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

// 初期表示
renderCalendar();

//登録ボタンをクリック
$("#btn").on("click",function() {
    //axiosでAjax送信（非同期通信）

    //送信データをオブジェクト変数で用意！
    const params = new URLSearchParams();
    params.append('seki_syubetu',  $("#seki_syubetu").val());
    params.append('formattedDate', 'formattedDate');

    //axiosでAjax送信
    axios.post('insert.php',params).then(function (response) {
        console.log(typeof response.data);//通信OK
        if(response.data==true){
           $("#status").html(response.data);
        }
    }).catch(function (error) {
        console.log(error);//通信Error
    }).then(function () {
        console.log("Last");//通信OK/Error後に処理を必ずさせたい場合
    });
});
</script>

</body>
</html>
