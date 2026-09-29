export function AppSidebarHeader() {
    return (
        <div className="flex items-center gap-3 border-b border-b-[#1f3347] shrink-0 px-4 py-5">
            <img
                src="/logo.svg"
                alt="logo"
                className="w-14 h-12 shrink-0 object-contain"
            />
            <div className="overflow-hidden">
                <p
                    className="text-[10px] font-semibold tracking-widest uppercase"
                    style={{ color: "#2ac1d8" }}
                >
                    Maximum Accountability
                </p>
                <p className="text-xs font-medium text-white leading-tight">
                    Learning Management
                </p>
            </div>
        </div>
    );
}
