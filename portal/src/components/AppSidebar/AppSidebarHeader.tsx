import logo from "@/assets/images/logo.webp";

export function AppSidebarHeader() {
  return (
    <div className="flex items-center justify-center gap-3 border-b border-b-[#D5E1DD] shrink-0 px-4 py-2">
      <img
        src={logo}
        alt="logo"
        className="w-56 h-12 shrink-0 object-contain"
      />
    </div>
  );
}
