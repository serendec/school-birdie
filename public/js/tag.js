// タグ追加
document.getElementById('input-tag').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const value = selectedOption.value;
    const name = selectedOption.text;

    if (value !== ""){
        let tagList = document.getElementById('tag-list');
        
        // 選択状況のチェック
        let existingTag = Array.from(tagList.children).find(child => {
            let hiddenInput = child.querySelector('input[type="hidden"]');
            return hiddenInput && hiddenInput.value === value;
        });
        if (existingTag) {
            alert('既に選択されております。');
            this.value = "";
            return;
        }

        // タグボタンの生成
        const tagButton = document.createElement("span");
        tagButton.className = "tag";
        tagButton.innerText = name;

        const closeButton = document.createElement("button");
        closeButton.type = "button";
        closeButton.className = "material-symbols-outlined";
        closeButton.innerText = "close";
        tagButton.appendChild(closeButton);

        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "tag_ids[]";
        hiddenInput.value = value;
        tagButton.appendChild(hiddenInput);

        tagList.appendChild(tagButton);

        // 初期化
        this.value = "";
    }
});
document.querySelector('.tagbox').addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('material-symbols-outlined')) {
        let tagButton = e.target.closest('.tag');
        tagButton.remove();
    }
});
