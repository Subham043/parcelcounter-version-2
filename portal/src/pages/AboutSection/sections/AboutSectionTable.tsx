import TableRowLoading from "@/components/TableRowLoading";
import type { AboutSectionType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useAboutSectionModalStore } from "../store/about-section-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import AboutSectionDeleteBtn from "./AboutSectionDeleteBtn";
import StatusToggleBadge from "@/components/StatusToggleBadge";
import { useAboutSectionToggleStatusMutation } from "@/utils/data/mutation/about_section";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";

type AboutSectionTableProps = {
  sections: AboutSectionType[];
  loading: boolean;
};

const AboutSectionTableRow = memo(function AboutSectionTableRow({
  id,
  heading,
  description_unfiltered,
  image_url,
  is_active,
  created_at,
}: {
  id: AboutSectionType["id"];
  heading: AboutSectionType["heading"];
  description_unfiltered: AboutSectionType["description_unfiltered"];
  image_url: AboutSectionType["image_url"];
  is_active: AboutSectionType["is_active"];
  created_at: AboutSectionType["created_at"];
}) {
  const aboutSectionToggleStatusMutation =
    useAboutSectionToggleStatusMutation(id);

  const onToggle = useCallback(async () => {
    await aboutSectionToggleStatusMutation.mutateAsync(undefined);
  }, [aboutSectionToggleStatusMutation]);
  const handleModalEdit = useAboutSectionModalStore(
    (state) => state.handleModalEdit,
  );
  const onEditHandler = useCallback(() => {
    handleModalEdit(id);
  }, [id, handleModalEdit]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <div className="flex items-center gap-2 py-1 ">
          <Avatar className="h-8 w-8 rounded-lg">
            <AvatarImage src={image_url} alt={heading} />
            <AvatarFallback className="rounded-lg">
              {getNameInitials(heading)}
            </AvatarFallback>
          </Avatar>
          <div className="px-1">
            <p className="text-sm font-medium text-gray-800">{heading}</p>
          </div>
        </div>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {description_unfiltered}
        </p>
      </td>
      <td className="px-4 py-3 ">
        <StatusToggleBadge
          isActive={is_active}
          onToggle={onToggle}
          loading={aboutSectionToggleStatusMutation.isPending}
        />
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {format(created_at, "dd MMM yyyy, hh:mm a")}
        </p>
      </td>
      <td className="px-4 py-3 text-right">
        <div className="flex items-center gap-2 justify-end">
          <Button size="xs" variant="secondary" onClick={onEditHandler}>
            Edit
          </Button>
          <AboutSectionDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function AboutSectionTable({ loading, sections }: AboutSectionTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Heading", "Description", "Is Active", "Created At", ""].map(
            (h) => (
              <th key={h} className="px-4 py-3 text-left font-medium">
                {h}
              </th>
            ),
          )}
        </tr>
      </thead>
      <tbody className="divide-y divide-gray-100">
        {loading ? (
          <TableRowLoading colSpan={5} />
        ) : (
          sections.map((item) => (
            <AboutSectionTableRow
              key={item.id}
              id={item.id}
              heading={item.heading}
              image_url={item.image_url}
              description_unfiltered={item.description_unfiltered}
              is_active={item.is_active}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(AboutSectionTable);
