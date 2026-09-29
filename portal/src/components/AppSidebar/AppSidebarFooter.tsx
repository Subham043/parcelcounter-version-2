import { env } from "@/configs/env";
import { cn } from "@/lib/utils";
import { useLogoutMutation } from "@/utils/data/mutation/profile";
import { ExternalLink, Loader2, LogOut, User } from "lucide-react";
import { useCallback } from "react";
import { NavLink } from "react-router";

const LogoutBtn = () => {
    const logoutMutate = useLogoutMutation();

    const onLogoutHandler = useCallback(async () => {
        await logoutMutate.mutateAsync();
    }, [logoutMutate.mutateAsync]);
    return (
        <button
            onClick={onLogoutHandler}
            disabled={logoutMutate.isPending}
            className="cursor-pointer flex items-center gap-3 rounded-lg text-sm transition-colors no-underline px-3 py-2 text-red-400 hover:text-red-300 hover:bg-red-900/20 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            <span className="shrink-0 text-base">
                {logoutMutate.isPending ? (
                    <Loader2 className="animate-spin" />
                ) : (
                    <LogOut size={17} />
                )}
            </span>
            <span className="truncate">Log Out</span>
        </button>
    );
};

export function AppSidebarFooter() {
    return (
        <div className="border-t border-t-[#1f3347] space-y-0.5 shrink-0 px-2 py-3">
            <NavLink
                key="/profile"
                to="/profile"
                title="Profile"
                className={({ isActive }) =>
                    cn(
                        "flex items-center gap-3 rounded-lg text-sm transition-colors no-underline px-3 py-2",
                        isActive
                            ? "text-white font-medium bg-[#1e3a52]"
                            : "text-[#c8d8ec] hover:text-white",
                    )
                }
            >
                <span className="shrink-0 text-base">
                    <User size={17} />
                </span>
                <span className="truncate">Profile</span>
            </NavLink>
            <NavLink
                key={env.PORTAL_REDIRECTION}
                to={env.PORTAL_REDIRECTION}
                title="Portal"
                target="_blank"
                className={({ isActive }) =>
                    cn(
                        "flex items-center gap-3 rounded-lg text-sm transition-colors no-underline px-3 py-2",
                        isActive
                            ? "text-white font-medium bg-[#1e3a52]"
                            : "text-[#c8d8ec] hover:text-white",
                    )
                }
            >
                <span className="shrink-0 text-base">
                    <ExternalLink size={17} />
                </span>
                <span className="truncate">Portal</span>
            </NavLink>
            <LogoutBtn />
        </div>
    );
}
