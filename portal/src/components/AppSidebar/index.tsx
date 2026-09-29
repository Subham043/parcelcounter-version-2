import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from "@/components/ui/sidebar";
import { AppSidebarNavMenus } from "./AppSidebarNavMenus";
import { AppSidebarFooter } from "./AppSidebarFooter";
import { AppSidebarHeader } from "./AppSidebarHeader";

export function AppSidebar({ ...props }: React.ComponentProps<typeof Sidebar>) {
    return (
        <Sidebar {...props}>
            <SidebarHeader className=" border-sidebar-border">
                <AppSidebarHeader />
            </SidebarHeader>
            <SidebarContent>
                <AppSidebarNavMenus />
            </SidebarContent>
            <SidebarFooter>
                <AppSidebarFooter />
            </SidebarFooter>
        </Sidebar>
    );
}
