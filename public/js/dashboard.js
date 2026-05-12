function animateCounter($counter) {
    const target = +$counter.data("target");
    const duration = 1200;
    const startTime = performance.now();

    function animate(time) {
        const progress = Math.min((time - startTime) / duration, 1);
        const ease = 1 - Math.pow(1 - progress, 3);

        const value = Math.floor(ease * target);
        $counter.text(value.toLocaleString("id-ID"));

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            $counter.text(target.toLocaleString("id-ID"));
        }
    }

    requestAnimationFrame(animate);
}

// ===== INTERSECTION OBSERVER =====
const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const $counter = $(entry.target).find(".counter");

                if (!$(entry.target).hasClass("animated")) {
                    animateCounter($counter);
                    $(entry.target).addClass("animated");
                }
            }
        });
    },
    {
        threshold: 0.6,
    },
);

$(".stat-card").each(function () {
    observer.observe(this);
});
