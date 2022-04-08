// Retourne le bon objet de thème en fonction du type de thème passé
export const getTheme = (theme) => (theme === "light" ? light : dark);

const dark = {
    body: {
        background: "#383838",
        textColor: "#FFFFFF",
    },
    components: {
        background: "#7c7c7c",
        textColor: "#FFFFFF"
    }
};

const light = {
    body: {
        background: "#F9F9FA",
        textColor: "#545454",
    },
    components: {
        background: "#F9F9FA",
        textColor: "#545454"
    }
};