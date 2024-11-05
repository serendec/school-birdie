$(function() {
    // アラートボックス
    $('.close-msg-btn').on('click', function() {
        $('.messagebox').fadeOut();
    });

    // フィルターボタン
    const filterButton = document.getElementById('filter-button');
    if (filterButton !== null) {
        filterButton.addEventListener('click', function () {
            const filterList = document.getElementById('filterlist');
            if (filterList.classList.contains('show')) {
                filterList.classList.remove('show');
            } else {
                filterList.classList.add('show');
            }
        });
    }

    // フィルターリセットボタン
    const filterResetButton = document.getElementById('filter-reset-button');
    if (filterResetButton !== null) {
        filterResetButton.addEventListener('click', function () {
            const title = document.getElementById('input-title');
            if (title !== null) title.value = '';
            const tagList = document.getElementById('tag-list');
            if (tagList !== null) tagList.innerHTML = '';
            const from = document.getElementById('input-from');
            if (from !== null) from.value = '';
            const to = document.getElementById('input-to');
            if (to !== null) to.value = '';
            const name = document.getElementById('input-name');
            if (name !== null) name.value = '';
            const nickname = document.getElementById('input-nickname');
            if (nickname !== null) nickname.value = '';
            const tel = document.getElementById('input-tel');
            if (tel !== null) tel.value = '';
            const email = document.getElementById('input-email');
            if (email !== null) email.value = '';
            const student = document.getElementById('select-student');
            if (student !== null){
                $('#select-student').val(null).trigger('change');
            }
            const teacher = document.getElementById('select-teacher');
            if (teacher !== null){
                $('#select-teacher').val(null).trigger('change');
            }
            const mainTeacher = document.getElementById('select-main_teacher');
            if (mainTeacher !== null){
                $('#select-main_teacher').val(null).trigger('change');
            }
            const subTeacher = document.getElementById('select-sub_teacher');
            if (subTeacher !== null){
                $('#select-sub_teacher').val(null).trigger('change');
            }
            const user = document.getElementById('select-user');
            if (user !== null) user.value = '';
            const postStatus = document.getElementById('post_status');
            if (postStatus !== null) postStatus.checked = false;
            const unread = document.getElementById('unread');
            if (unread !== null) unread.checked = false;
            const inactive = document.getElementById('inactive');
            if (inactive !== null) inactive.checked = false;
        });
    }

    // 削除ボタン
    $('#delete-btn').on('click', function() {
        if (confirm('本当に削除しますか？')) {
            $('#delete-form').submit();
        }
    });

    // セレクトボックス
    if (document.getElementById('select-student') !== null) {
        const selectStudent = $('#select-student').select2({
            language: "ja"
        });

        // レッスン記録の場合
        const historyLink = document.getElementById('history_link');
        if (historyLink !== null) {
            selectStudent.on('change', function() {
                historyLink.innerHTML = "";
                
                const studentId = $(this).val();
                if (studentId == '') return;

                // 選択された生徒のレッスン記録一覧へのリンクを追加
                const link = document.createElement("a");
                link.href = `/lesson_record/search?student_id=${studentId}`;
                link.innerText = "生徒のレッスン履歴を確認";
                link.target = "_blank";    
                historyLink.appendChild(link);
            });
        }
    }
    if (document.getElementById('select-teacher') !== null) {
        $('#select-teacher').select2({
            language: "ja"
        });
    }
    if (document.getElementById('select-main_teacher') !== null) {
        $('#select-main_teacher').select2({
            language: "ja"
        });
    }
    if (document.getElementById('select-sub_teacher') !== null) {
        $('#select-sub_teacher').select2({
            language: "ja"
        });
    }
});
