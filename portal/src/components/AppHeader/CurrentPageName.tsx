import { page_routes } from "@/utils/routes/page_routes";
import { useMemo } from "react";
import { useLocation } from "react-router";

function CurrentPageName() {
    const location = useLocation();
    const page_name = useMemo(() => {
        const activeRoute = Object.values(page_routes).find((route) =>
            location.pathname.includes(route.link),
        );
        return activeRoute?.name || page_routes.dashboard.name;
    }, [location.pathname]);
    return (
        <p className="truncate text-gray-500 uppercase tracking-wide text-sm font-medium">
            {page_name.toLocaleUpperCase()}
        </p>
    );
}

export default CurrentPageName;
