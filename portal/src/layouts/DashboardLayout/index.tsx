import AppHeader from "@/components/AppHeader";
import { AppSidebar } from "@/components/AppSidebar";
import SuspenseOutlet from "@/components/SuspenseOutlet";
import { SidebarInset, SidebarProvider } from "@/components/ui/sidebar";

export default function DashboardLayout() {
    return (
        <SidebarProvider>
            <AppSidebar />
            <SidebarInset className="min-w-0 overflow-x-hidden">
                <AppHeader />
                <div className="mt-16 min-w-0 px-4 py-1.5">
                    <SuspenseOutlet />
                </div>
            </SidebarInset>
        </SidebarProvider>
    );
}
