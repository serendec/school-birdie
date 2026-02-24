// 登録・更新画面でのアイコン欄制御
const buttonSelectFile = document.getElementById('button-select_file');
if (buttonSelectFile) {
    buttonSelectFile.addEventListener('click', function() {
        document.getElementById('icon').click();
    });
    document.getElementById('icon').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const reader = new FileReader();
        const img = document.getElementById('icon-select');

        reader.onload = function(e) {
            img.style.backgroundImage = 'url(' + e.target.result + ')';
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            img.style.backgroundImage = '/storage/img/default-icon.png';
        }
    });
}
// スクールのトップ画像欄制御
const buttonSelectImgFile = document.getElementById('button-select_img_file');
if (buttonSelectImgFile) {
    buttonSelectImgFile.addEventListener('click', function() {
        document.getElementById('input-file').click();
    });
    document.getElementById('input-file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const reader = new FileReader();
        const img = document.getElementById('selected_top_img');

        reader.onload = function(e) {
            img.style.backgroundImage = 'url(' + e.target.result + ')';
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            img.style.backgroundImage = '/storage/img/default-top.jpg';
        }
    });
}

// 生徒更新機能におけるサブ講師追加
const selectSubTeacher = document.getElementById('select-sub_teacher');
if (selectSubTeacher) {
    $('#select-sub_teacher').on('select2:select', function(e) {
        const selectedOption = this.options[this.selectedIndex];
        const value = selectedOption.value;
        const name = selectedOption.text;

        if (value !== ""){
            let teacherList = document.getElementById('sub_teacher-list');

            // 選択状況のチェック
            let existingTag = Array.from(teacherList.children).find(child => {
                let hiddenInput = child.querySelector('input[type="hidden"]');
                return hiddenInput && hiddenInput.value === value;
            });
            if (existingTag) {
                alert('既に選択されております。');
                $(this).val(null).trigger('change');
                return;
            }

            // サブ講師ボタンの生成
            const subTeacherButton = document.createElement("span");
            subTeacherButton.className = "tag";
            subTeacherButton.innerText = name;

            const closeButton = document.createElement("button");
            closeButton.type = "button";
            closeButton.className = "material-symbols-outlined";
            closeButton.innerText = "close";
            subTeacherButton.appendChild(closeButton);

            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "sub_teacher_ids[]";
            hiddenInput.value = value;
            subTeacherButton.appendChild(hiddenInput);

            teacherList.appendChild(subTeacherButton);

            // 初期化
            $(this).val(null).trigger('change');
        }
    });
    document.querySelector('.tagbox').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('material-symbols-outlined')) {
            let subTeacherButton = e.target.closest('.tag');
            subTeacherButton.remove();
        }
    });
}
