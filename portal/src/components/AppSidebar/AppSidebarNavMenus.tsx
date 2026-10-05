import {
  LayoutDashboard,
  ChevronDown,
  ChevronRight,
  BanknoteArrowUp,
  ClipboardClock,
  ScrollText,
  UserStar,
  HandCoins,
  MessageSquareDot,
  Image,
  CreditCard,
  Gavel,
  FilePenLine,
  ChartBarStacked,
  ChartColumnStacked,
} from "lucide-react";
import { cn } from "@/utils/lib/utils";
import { useMemo, useState } from "react";
import { NavLink } from "react-router";
import { page_routes } from "@/utils/routes/page_routes";
// import type { AvailablePermissions, AvailableRoles } from "@/utils/types";
// import { usePermissions } from "@/hooks/usePermissions";

interface NavItem {
  label: string;
  icon: React.ReactNode;
  to: string;
  children?: { label: string; to: string }[];
  // allowedRolesAndPermission: (AvailableRoles | AvailablePermissions)[];
}

interface NavSection {
  section?: string;
  items: NavItem[];
  // allowedRolesAndPermission: (AvailableRoles | AvailablePermissions)[];
}

const navSections: NavSection[] = [
  {
    items: [
      {
        label: page_routes.dashboard.name,
        icon: <LayoutDashboard size={17} />,
        to: page_routes.dashboard.link,
        // allowedRolesAndPermission: [
        //   "canManageCourses",
        //   "canModifyRecords",
        //   "canSwitchOrganization",
        //   "Super Admin",
        //   "Admin",
        //   "Instructor",
        //   "Learner",
        // ],
      },
      {
        label: page_routes.charges.name,
        icon: <BanknoteArrowUp size={17} />,
        to: page_routes.charges.link,
      },
      {
        label: page_routes.delivery_slots.name,
        icon: <ClipboardClock size={17} />,
        to: page_routes.delivery_slots.link,
      },
      {
        label: page_routes.features.name,
        icon: <ScrollText size={17} />,
        to: page_routes.features.link,
      },
      {
        label: page_routes.testimonials.name,
        icon: <UserStar size={17} />,
        to: page_routes.testimonials.link,
      },
      {
        label: page_routes.tax.name,
        icon: <HandCoins size={17} />,
        to: page_routes.tax.link,
      },
      {
        label: page_routes.contact_form_enquiry.name,
        icon: <MessageSquareDot size={17} />,
        to: page_routes.contact_form_enquiry.link,
      },
      {
        label: page_routes.banners.name,
        icon: <Image size={17} />,
        to: page_routes.banners.link,
      },
      {
        label: page_routes.payment_options.name,
        icon: <CreditCard size={17} />,
        to: page_routes.payment_options.link,
      },
      {
        label: page_routes.legal_content.name,
        icon: <Gavel size={17} />,
        to: page_routes.legal_content.link,
      },
      {
        label: page_routes.blogs.name,
        icon: <FilePenLine size={17} />,
        to: page_routes.blogs.link,
      },
      {
        label: page_routes.categories.name,
        icon: <ChartBarStacked size={17} />,
        to: page_routes.categories.link,
      },
      {
        label: page_routes.sub_categories.name,
        icon: <ChartColumnStacked size={17} />,
        to: page_routes.sub_categories.link,
      },
    ],
    // allowedRolesAndPermission: [
    //   "canManageCourses",
    //   "canModifyRecords",
    //   "canSwitchOrganization",
    //   "Super Admin",
    //   "Admin",
    //   "Instructor",
    //   "Learner",
    // ],
  },
  // {
  //   section: "MANAGE TRAINING",
  //   items: [
  //     {
  //       label: page_routes.manage_training_course.name,
  //       icon: <BookOpenText size={17} />,
  //       to: page_routes.manage_training_course.link,
  //       allowedRolesAndPermission: ["canManageCourses", "Super Admin", "Admin"],
  //     },
  //     {
  //       label: page_routes.manage_training_category.name,
  //       icon: <ChartBarStacked size={17} />,
  //       to: page_routes.manage_training_category.link,
  //       allowedRolesAndPermission: ["canManageCourses", "Super Admin", "Admin"],
  //     },
  //     {
  //       label: page_routes.manage_training_sub_category.name,
  //       icon: <ChartColumnStacked size={17} />,
  //       to: page_routes.manage_training_sub_category.link,
  //       allowedRolesAndPermission: ["canManageCourses", "Super Admin", "Admin"],
  //     },
  //   ],
  //   allowedRolesAndPermission: ["canManageCourses", "Super Admin", "Admin"],
  // },
];

export function AppSidebarNavMenus() {
  // const { hasAnyRoleOrPermission } = usePermissions();
  const [expandedSections, setExpandedSections] = useState<Set<string>>(
    () =>
      new Set(
        navSections.filter((sec) => sec.section).map((sec) => sec.section!),
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
      .filter(() => {
        // return hasAnyRoleOrPermission(section.allowedRolesAndPermission);
        return true;
      })
      .map((item) => ({
        ...item,
        items: item.items.filter(() => {
          // hasAnyRoleOrPermission(it.allowedRolesAndPermission)
          return true;
        }),
      }));
  }, []);

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
                <ChevronDown size={12} style={{ color: "#6b849e" }} />
              ) : (
                <ChevronRight size={12} style={{ color: "#6b849e" }} />
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
                    "flex items-center gap-3 rounded-md text-sm transition-colors no-underline px-3 py-2",
                    isActive
                      ? "text-[#DCEAE5] font-medium bg-[#193B32]"
                      : "text-[#000000] hover:text-[#334E48]",
                  )
                }
              >
                <span className="shrink-0 text-base">{item.icon}</span>
                <span className="truncate">{item.label}</span>
              </NavLink>
            ))}
        </div>
      ))}
    </nav>
  );
}
