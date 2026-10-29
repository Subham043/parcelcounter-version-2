import logo from "@/assets/images/logo.webp";

export function AppSidebarHeader() {
  return (
    <div className="flex items-center justify-center gap-3 border-b border-b-[#D5E1DD] shrink-0 px-4 py-1.5">
      <img
        src={logo}
        alt="logo"
        className="h-[3.2rem] shrink-0 object-contain"
      />
    </div>
  );
}
