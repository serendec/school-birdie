// タグ追加
const btnAddTag = document.getElementById('btn-add-tag');
if (btnAddTag !== null) {
    btnAddTag.addEventListener('click', function(e) {
        const tag = document.getElementById('input-tag');
        const selectedOption = tag.options[tag.selectedIndex];
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
                return;
            }

            // タグボタンの生成
            const tagButton = document.createElement("span");
            tagButton.className = "tagbutton";
            tagButton.innerText = name;

            const closeButton = document.createElement("button");
            closeButton.type = "button";

            const closeText = document.createElement("span");
            closeText.className = "material-symbols-outlined";
            closeText.innerText = "close";
            closeButton.appendChild(closeText);
            tagButton.appendChild(closeButton);

            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "tag_ids[]";
            hiddenInput.value = value;
            tagButton.appendChild(hiddenInput);

            tagList.appendChild(tagButton);
        }
    });
    document.querySelector('.tagbox').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('material-symbols-outlined')) {
            let tagButton = e.target.closest('.tagbutton');
            tagButton.remove();
        }
    });
}

const likeButton = document.getElementById('topic-like-button');
if (likeButton !== null) {
    likeButton.addEventListener('click', function () {
        const forumId = likeButton.dataset.forumId;
        const liked = likeButton.dataset.liked === 'true';
        const url = `/forum/${forumId}/toggle-like`;
        const token = document.querySelector('meta[name="csrf-token"]').content;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then((response) => response.json())
        .then((data) => {
            // Toggle the like status
            this.dataset.liked = !liked;

            // Update the button label and icon
            const icon = this.querySelector('.material-symbols-outlined');
            const likeCountSpan = icon.nextElementSibling;
            const currentCount = (likeCountSpan.textContent != '') ? parseInt(likeCountSpan.textContent) : 0;

            if (!liked) {
                likeButton.classList.remove('type--third');
                likeButton.classList.add('type--current');
                likeCountSpan.textContent = currentCount + 1;
            } else {
                likeButton.classList.remove('type--current');
                likeButton.classList.add('type--third');
                likeCountSpan.textContent = ((currentCount - 1) > 0) ? currentCount - 1 : '';
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });
}
