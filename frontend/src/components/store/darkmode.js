import { onMounted, ref } from "vue";

export const useDarkMode = {
  setup() {
    const isDarkMode = ref(false);
    function toggleDarkMode() {
      const body = document.body;
      body.classList.toggle("dark-mode");
      isDarkMode.value = body.classList.contains("dark-mode");
      localStorage.setItem("theme", isDarkMode.value ? "dark" : "light");
    }

    onMounted(() => {
      const savedTheme = localStorage.getItem("theme");
      if (savedTheme === "dark") {
        document.body.classList.add("dark-mode");
        isDarkMode.value = true;
      } else {
        document.body.classList.remove("dark-mode");
        isDarkMode.value = false;
      }
    });

    return {
      toggleDarkMode,
      isDarkMode,
    };
  },
};
