import {
  SIDEBAR_WIDTH,
  SIDEBAR_WIDTH_MOBILE,
  SidebarTrigger,
  useSidebar,
} from "../ui/sidebar";
import { Separator } from "../ui/separator";
import CurrentPageName from "./CurrentPageName";
import ProfileBtn from "./ProfileBtn";

function AppHeader() {
  const { isMobile, open } = useSidebar();
  return (
    <header
      className={`fixed top-0 right-0 transition-all duration-300 ease-in-out flex justify-between h-16 shrink-0 bg-background items-center gap-2 group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 border-b`}
      style={{
        width: `calc(100% - ${
          open ? (isMobile ? SIDEBAR_WIDTH_MOBILE : SIDEBAR_WIDTH) : "0px"
        })`,
      }}
    >
      <div className="flex items-center gap-2 px-4">
        <SidebarTrigger className="-ml-1" />
        <Separator
          orientation="vertical"
          className="data-[orientation=vertical]:h-4 w-0.5 hidden sm:inline data-[orientation=vertical]:bg-gray-400 data-[orientation=vertical]:self-center"
        />
        <CurrentPageName />
      </div>
      <div className="w-auto px-4 flex gap-2 items-center justify-end">
        <ProfileBtn />
      </div>
    </header>
  );
}

export default AppHeader;
