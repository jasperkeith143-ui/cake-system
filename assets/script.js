document.addEventListener("DOMContentLoaded", () => {

    // smooth page load
    document.body.style.opacity = 0;
    setTimeout(() => {
        document.body.style.transition = "0.8s ease";
        document.body.style.opacity = 1;
    }, 100);

    // soft button press
    document.querySelectorAll("button").forEach(btn => {
        btn.addEventListener("click", () => {
            btn.style.transform = "scale(0.92)";
            setTimeout(() => btn.style.transform = "scale(1)", 140);
        });
    });

    // card hover micro animation
    document.querySelectorAll(".card").forEach(card => {
        card.addEventListener("mousemove", (e) => {
            const x = e.offsetX;
            const y = e.offsetY;

            card.style.transform = `
                perspective(600px)
                rotateX(${(y - 100) / 20}deg)
                rotateY(${(x - 100) / 20}deg)
                scale(1.03)
            `;
        });

        card.addEventListener("mouseleave", () => {
            card.style.transform = "none";
        });
    });

});

document.addEventListener("DOMContentLoaded", () => {

    // page fade-in
    document.body.style.opacity = 0;

    setTimeout(() => {
        document.body.style.transition = "0.8s ease";
        document.body.style.opacity = 1;
    }, 100);

    // button press effect
    document.querySelectorAll("button").forEach(btn => {
        btn.addEventListener("click", () => {
            btn.style.transform = "scale(0.95)";
            setTimeout(() => {
                btn.style.transform = "scale(1)";
            }, 120);
        });
    });

});
function toggleRegister() {
    const card = document.getElementById("registerCard");
    card.classList.toggle("active");
}