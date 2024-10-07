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
            const month = monthNames[currentDate.getMonth()];
            alert(`クリックした日付: ${day}日 (${month} ${year})`);
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