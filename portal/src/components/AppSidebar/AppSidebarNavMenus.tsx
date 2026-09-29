import {
    LayoutDashboard,
    Users,
    User,
    ChevronDown,
    ChevronRight,
    GraduationCap,
    ScrollText,
    BookOpenText,
    ChartBarStacked,
    ChartColumnStacked,
    BookOpenCheck,
    Landmark,
    UserCheck,
    UserKey,
    Library,
} from "lucide-react";
import { cn } from "@/lib/utils";
import { useMemo, useState } from "react";
import { NavLink } from "react-router";
import { page_routes } from "@/utils/routes/page_routes";
import type { AvailablePermissions, AvailableRoles } from "@/utils/types";
import { usePermissions } from "@/hooks/usePermissions";

interface NavItem {
    label: string;
    icon: React.ReactNode;
    to: string;
    children?: { label: string; to: string }[];
    allowedRolesAndPermission: (AvailableRoles | AvailablePermissions)[];
}

interface NavSection {
    section?: string;
    items: NavItem[];
    allowedRolesAndPermission: (AvailableRoles | AvailablePermissions)[];
}

const navSections: NavSection[] = [
    {
        items: [
            {
                label: page_routes.dashboard.name,
                icon: <LayoutDashboard size={17} />,
                to: page_routes.dashboard.link,
                allowedRolesAndPermission: [
                    "canManageCourses",
                    "canModifyRecords",
                    "canSwitchOrganization",
                    "Super Admin",
                    "Admin",
                    "Instructor",
                    "Learner",
                ],
            },
            {
                label: page_routes.my_training.name,
                icon: <GraduationCap size={17} />,
                to: page_routes.my_training.link,
                allowedRolesAndPermission: [
                    "canManageCourses",
                    "canModifyRecords",
                    "canSwitchOrganization",
                    "Super Admin",
                    "Admin",
                    "Instructor",
                    "Learner",
                ],
            },
            {
                label: page_routes.my_team.name,
                icon: <Users size={17} />,
                to: page_routes.my_team.link,
                allowedRolesAndPermission: [
                    "Super Admin",
                    "Admin",
                    "Instructor",
                ],
            },
            {
                label: page_routes.training_catalog.name,
                icon: <Library size={17} />,
                to: page_routes.training_catalog.link,
                allowedRolesAndPermission: [
                    "canManageCourses",
                    "canModifyRecords",
                    "canSwitchOrganization",
                    "Super Admin",
                    "Admin",
                    "Instructor",
                    "Learner",
                ],
            },
            {
                label: page_routes.enrollment.name,
                icon: <ScrollText size={17} />,
                to: page_routes.enrollment.link,
                allowedRolesAndPermission: [
                    "canSwitchOrganization",
                    "Super Admin",
                    "Admin",
                ],
            },
        ],
        allowedRolesAndPermission: [
            "canManageCourses",
            "canModifyRecords",
            "canSwitchOrganization",
            "Super Admin",
            "Admin",
            "Instructor",
            "Learner",
        ],
    },
    {
        section: "MANAGE TRAINING",
        items: [
            {
                label: page_routes.manage_training_course.name,
                icon: <BookOpenText size={17} />,
                to: page_routes.manage_training_course.link,
                allowedRolesAndPermission: [
                    "canManageCourses",
                    "Super Admin",
                    "Admin",
                ],
            },
            {
                label: page_routes.manage_training_category.name,
                icon: <ChartBarStacked size={17} />,
                to: page_routes.manage_training_category.link,
                allowedRolesAndPermission: [
                    "canManageCourses",
                    "Super Admin",
                    "Admin",
                ],
            },
            {
                label: page_routes.manage_training_sub_category.name,
                icon: <ChartColumnStacked size={17} />,
                to: page_routes.manage_training_sub_category.link,
                allowedRolesAndPermission: [
                    "canManageCourses",
                    "Super Admin",
                    "Admin",
                ],
            },
        ],
        allowedRolesAndPermission: ["canManageCourses", "Super Admin", "Admin"],
    },
    {
        section: "REPORTS",
        items: [
            {
                label: page_routes.user_report.name,
                icon: <UserCheck size={17} />,
                to: page_routes.user_report.link,
                allowedRolesAndPermission: [
                    "Super Admin",
                    "Admin",
                    "Instructor",
                ],
            },
            {
                label: page_routes.course_report.name,
                icon: <BookOpenCheck size={17} />,
                to: page_routes.course_report.link,
                allowedRolesAndPermission: [
                    "Super Admin",
                    "Admin",
                    "Instructor",
                ],
            },
        ],
        allowedRolesAndPermission: ["Super Admin", "Admin", "Instructor"],
    },
    {
        section: "ADMIN",
        items: [
            {
                label: page_routes.admin_users.name,
                icon: <User size={17} />,
                to: page_routes.admin_users.link,
                allowedRolesAndPermission: [
                    "canSwitchOrganization",
                    "Super Admin",
                    "Admin",
                ],
            },
            {
                label: page_routes.admin_roles.name,
                icon: <UserKey size={17} />,
                to: page_routes.admin_roles.link,
                allowedRolesAndPermission: [
                    "canSwitchOrganization",
                    "Super Admin",
                    "Admin",
                ],
            },
            {
                label: page_routes.manage_library.name,
                icon: <Landmark size={17} />,
                to: page_routes.manage_library.link,
                allowedRolesAndPermission: [
                    "canSwitchOrganization",
                    "Super Admin",
                ],
            },
        ],
        allowedRolesAndPermission: [
            "canSwitchOrganization",
            "Super Admin",
            "Admin",
        ],
    },
];

export function AppSidebarNavMenus() {
    const { hasAnyRoleOrPermission } = usePermissions();
    const [expandedSections, setExpandedSections] = useState<Set<string>>(
        () =>
            new Set(
                navSections
                    .filter((sec) => sec.section)
                    .map((sec) => sec.section!),
            ),
    );

    function toggleSection(s: string) {
        setExpandedSections((prev) => {
            const next = new Set(prev);
            next.has(s) ? next.delete(s) : next.add(s);
            return next;
        });
    }

    const allowedNavSections = useMemo(() => {
        return navSections
            .filter((section) => {
                return hasAnyRoleOrPermission(
                    section.allowedRolesAndPermission,
                );
            })
            .map((item) => ({
                ...item,
                items: item.items.filter((it) =>
                    hasAnyRoleOrPermission(it.allowedRolesAndPermission),
                ),
            }));
    }, [hasAnyRoleOrPermission]);

    return (
        <nav className="flex-1 overflow-y-auto space-y-0.5 scrollbar-none py-3 px-2">
            {allowedNavSections.map((sec, si) => (
                <div key={si} className="mb-1">
                    {/* Section header - only show when expanded */}
                    {sec.section && (
                        <button
                            onClick={() => toggleSection(sec.section!)}
                            className="flex items-center justify-between w-full px-2 py-2 mb-0.5"
                        >
                            <span
                                className="text-xs font-semibold tracking-widest uppercase"
                                style={{ color: "#6b849e" }}
                            >
                                {sec.section}
                            </span>
                            {expandedSections.has(sec.section) ? (
                                <ChevronDown
                                    size={12}
                                    style={{ color: "#6b849e" }}
                                />
                            ) : (
                                <ChevronRight
                                    size={12}
                                    style={{ color: "#6b849e" }}
                                />
                            )}
                        </button>
                    )}

                    {/* Items - always show when collapsed, or when section is expanded when not collapsed */}
                    {(!sec.section || expandedSections.has(sec.section!)) &&
                        sec.items.map((item) => (
                            <NavLink
                                key={item.to}
                                to={item.to}
                                end={item.to === "/"}
                                title={item.label}
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
                                    {item.icon}
                                </span>
                                <span className="truncate">{item.label}</span>
                            </NavLink>
                        ))}
                </div>
            ))}
        </nav>
    );
}
