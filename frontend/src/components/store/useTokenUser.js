import { onMounted, ref } from "vue";

export function useTokenUser() {
  const userString = localStorage.getItem("user_donezo");
  const tokenString = localStorage.getItem("token_donezo");

  const token = ref(null);
  const userId = ref(null);
  const avatar = ref(null);

  onMounted(() => {
    if (userString && tokenString) {
      try {
        const user = JSON.parse(userString);
        token.value = tokenString;
        userId.value = user.id;
        avatar.value = JSON.parse(user.user);
        // console.log('dd' +avatar.value);
      } catch (error) {
        console.error("Lỗi khi parse JSON từ localStorage:", error);
      }
    }
  });

  return {
    token,
    userId,
    avatar,
  };
}
