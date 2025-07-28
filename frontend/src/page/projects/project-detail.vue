<template>
  <div id="trello-board">
    <draggable v-model="lists" tag="div" class="list-container" item-key="id" group="lists">
      <template #item="{ element: list }">
        <div class="trello-list">
          <div class="list-header">
            <h3>{{ list.name }}</h3>
            <div class="list-actions">
              <span class="card-count">{{ list.cards.length }}</span>
              <div class="dropdown">
                <span class="icon-add" data-bs-toggle="dropdown" aria-expanded="false">+</span>
                <form class="dropdown-menu p-2 dropdown-menu-end" style="width: 300px">
                  <li>
                    <label class="form-label fw-normal" style="font-size: 14px">Tiêu đề nhiệm vụ</label>
                    <input type="text" class="form-control mb-2" />
                  </li>
                  <li>
                    <label class="form-label fw-normal" style="font-size: 14px">Người được phân công</label>
                    <select name="" id="" class="form-select border-bottom mb-3">
                      <option value="">sss</option>
                    </select>
                  </li>

                  <li class="d-flex justify-content-between">
                    <div class="d-flex gap-1">
                      <button class="btn btn-sm create-btn">Thêm</button>
                      <button class="btn btn-sm btn-secondary">
                        Chỉnh sửa
                      </button>
                    </div>

                    <button class="btn btn-sm btn-light border" style="color: #042d62">
                      <i class="bi bi-trash"></i>
                    </button>
                  </li>
                </form>
              </div>
            </div>
          </div>
          <div class="list-progress-bar">
            <div class="progress-fill" :style="{ width: list.progress * 100 + '%' }"></div>
          </div>
          <draggable v-model="list.cards" tag="div" class="card-container" item-key="id" group="cards">
            <template #item="{ element: card }">

              <div class="trello-card">
                <router-link :to="'/task'" class="text-decoration-none text-dark">
                  <div class="card-content">{{ card.content }}</div>
                  <div class="card-meta">
                    <span v-if="card.assignee" class="card-assignee">{{
                      card.assignee
                      }}</span>
                    <div class="card-icons">
                      <span v-if="card.starred" class="icon-star">&#9733;</span>
                      <span v-if="card.hasAttachments" class="icon-attach">&#128206;</span>
                      <div class="card-labels">
                        <span v-for="label in card.labels" :key="label.text" class="card-label"
                          :style="{ backgroundColor: label.color }">
                          {{ label.text }}
                        </span>
                      </div>
                    </div>
                  </div>

                </router-link>
              </div>
            </template>
          </draggable>

          <div class="dropdown">
            <span class="add-card-placeholder" data-bs-toggle="dropdown" aria-expanded="false">+ Thêm thẻ khác</span>
            <form class="dropdown-menu p-2 dropdown-menu-end" style="width: 300px">
              <li>
                <label class="form-label fw-normal" style="font-size: 14px">Tiêu đề nhiệm vụ</label>
                <input type="text" class="form-control mb-2" />
              </li>
              <li>
                <label class="form-label fw-normal" style="font-size: 14px">Người được phân công</label>
                <select name="" id="" class="form-select border-bottom mb-3">
                  <option value="">sss</option>
                </select>
              </li>

              <li class="d-flex justify-content-between">
                <div class="d-flex gap-1">
                  <button class="btn btn-sm create-btn">Thêm</button>
                  <button class="btn btn-sm btn-secondary">Chỉnh sửa</button>
                </div>

                <button class="btn btn-sm btn-light border" style="color: #042d62">
                  <i class="bi bi-trash"></i>
                </button>
              </li>
            </form>
          </div>
        </div>
      </template>
    </draggable>
  </div>
</template>

<script>
import draggable from "vuedraggable";

export default {
  components: {
    draggable,
  },
  data() {
    return {
      lists: [
        {
          id: 1,
          name: "Việc cần làm",
          progress: 0.8,
          cards: [
            {
              id: 101,
              content: "Figma admin Quản lý món ăn - mobile",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [{ text: "N", color: "#61bd4f" }],
            },
            {
              id: 102,
              content: "code chức năng mua hàng nâng bậc người dùng",
              assignee: "CEO CườngPN11",
              starred: true,
              hasAttachments: true,
              labels: [],
            },
            {
              id: 103,
              content: "Figma mobile trang chủ",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [],
            },
            {
              id: 104,
              content: "Figma admin Quản lý người dùng",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [],
            },
          ],
        },
        {
          id: 2,
          name: "Phân tích/Thiết kế",
          progress: 0.0,
          cards: [],
        },
        {
          id: 3,
          name: "Thực hiện",
          progress: 0.5,
          cards: [
            {
              id: 301,
              content: "Chức năng đăng nhập bằng Facebook",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [{ text: "N", color: "#0079bf" }],
            },
            {
              id: 302,
              content: "Code quản lý voucher",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [],
            },
            {
              id: 303,
              content: "Code chức năng quà tặng nâng bậc",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [],
            },
            {
              id: 304,
              content: "Code chức năng chat real-time",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [],
            },
          ],
        },
        {
          id: 4,
          name: "Kiểm thử",
          progress: 0.2,
          cards: [
            {
              id: 401,
              content: "code template flashsale",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [],
            },
            {
              id: 402,
              content: "code chức năng flashsale sản phẩm",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [{ text: "N", color: "#0079bf" }],
            },
          ],
        },
        {
          id: 5,
          name: "Hoàn tất",
          progress: 0.2,
          cards: [
            {
              id: 401,
              content: "code template flashsale",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [],
            },
            {
              id: 402,
              content: "code chức năng flashsale sản phẩm",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [{ text: "N", color: "#0079bf" }],
            },
          ],
        },
        {
          id: 6,
          name: "Huỷ bỏ",
          progress: 0.2,
          cards: [
            {
              id: 401,
              content: "code template flashsale",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [],
            },
            {
              id: 402,
              content: "code chức năng flashsale sản phẩm",
              assignee: "CEO CườngPN11",
              starred: false,
              hasAttachments: false,
              labels: [{ text: "N", color: "#0079bf" }],
            },
          ],
        },
      ],
    };
  },
};
</script>

<style scoped>
.create-btn {
  background-color: #042d62;
  color: #fff;
}

#trello-board {
  display: flex;
  padding: 10px;
  min-height: 100vh;
  overflow-x: auto;
  align-items: flex-start;
}

.list-container {
  display: flex;
}

.trello-list {
  background-color: #f5f5f7;
  border-radius: 3px;
  width: 310px;
  margin-right: 8px;
  /* Giảm margin giữa các list */
  padding: 8px;
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  max-height: calc(100vh - 10px);
  /* Điều chỉnh cho vừa màn hình */
  position: relative;
  /* Cho các phần tử con có position absolute */
}

.list-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 8px;
  padding: 0 4px;
  /* Giảm padding ngang */
  color: #172b4d;
}

.list-header h3 {
  margin: 0;
  font-size: 14px;
  /* Giảm kích thước chữ */
  font-weight: 600;
  /* Đậm hơn */
}

.list-actions {
  display: flex;
  align-items: center;
  gap: 8px;
  /* Khoảng cách giữa các icon */
  font-size: 14px;
  color: #6b778c;
  /* Màu xám nhạt cho icon và số lượng */
}

.card-count {
  background-color: #c4c6ca;
  /* Nền xám cho số lượng */
  border-radius: 50%;
  /* Bo tròn */
  width: 20px;
  height: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 12px;
  font-weight: bold;
  color: #fff;
}

.icon-add,
.icon-more {
  cursor: pointer;
  padding: 2px 4px;
  font-size: 24px;
}

.icon-add:hover,
.icon-more:hover {
  background-color: rgba(9, 30, 66, 0.08);
  border-radius: 3px;
}

.list-progress-bar {
  background-color: #d1d4d8;
  height: 5px;
  border-radius: 5px;
  margin-bottom: 8px;
  overflow: hidden;
}

.progress-fill {
  background-color: #042d62;
  height: 100%;
  border-radius: 5px;
  transition: width 0.3s ease-in-out;
}

.card-container {
  flex-grow: 1;
  min-height: 5px;
  overflow-y: auto;
  padding-right: 2px;
}

.trello-card {
  background-color: #fff;
  border-radius: 3px;
  box-shadow: 0 1px 0 rgba(9, 30, 66, 0.25);
  padding: 6px 8px;
  margin-bottom: 8px;
  cursor: pointer;
  word-wrap: break-word;
  color: #172b4d;
  font-size: 14px;
}

.trello-card:hover {
  background-color: #f4f5f7;
}

.card-content {
  margin-bottom: 4px;
}

.card-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 12px;
  color: #5e6c84;
}

.card-assignee {
  font-weight: 500;
}

.card-icons {
  display: flex;
  align-items: center;
  gap: 8px;
}

.list-actions .dropdown-menu {
  left: auto;
  right: 0;
  transform: translateX(-100%);
}

.dropdown .dropdown-menu {
  position: absolute;
}

.icon-star,
.icon-attach,
.icon-options {
  font-size: 14px;
  color: #6b778c;
}

.card-labels {
  display: flex;
  gap: 4px;
}

.card-label {
  display: inline-block;
  padding: 2px 6px;
  border-radius: 3px;
  font-weight: bold;
  font-size: 10px;
  color: #fff;
  text-transform: uppercase;
}

.add-card-placeholder,
.add-list-placeholder {
  color: #6b778c;
  padding: 8px 12px;
  cursor: pointer;
  margin-top: 8px;
  font-size: 14px;
  border-radius: 3px;
  display: flex;
  align-items: center;
  gap: 5px;
}

.add-card-placeholder:hover,
.add-list-placeholder:hover {
  background-color: rgba(9, 30, 66, 0.08);
  color: #172b4d;
}

/* Style cho "Thêm danh sách khác" */
.add-list-placeholder {
  width: 272px;
  background-color: rgba(0, 0, 0, 0.1);
  /* Nền hơi tối */
  color: #fff;
  margin-left: 8px;
  display: flex;
  align-items: center;
  font-weight: bold;
}

.add-list-placeholder:hover {
  background-color: rgba(0, 0, 0, 0.2);
  color: #fff;
}
</style>
