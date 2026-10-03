import TableRowLoading from "@/components/TableRowLoading";
import type { ContactFormEnquiryType } from "@/utils/types";
import { memo, useCallback } from "react";
import { useContactFormEnquiryModalStore } from "../store/contact-form-enquiry-modal.store";
import { Button } from "@/components/ui/button";
import { format } from "date-fns";
import ContactFormEnquiryDeleteBtn from "./ContactFormEnquiryDeleteBtn";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { getNameInitials } from "@/utils/helper";

type ContactFormEnquiryTableProps = {
  enquiries: ContactFormEnquiryType[];
  loading: boolean;
};

const ContactFormEnquiryTableRow = memo(function ContactFormEnquiryTableRow({
  id,
  name,
  email,
  phone,
  message,
  subject,
  page_url,
  created_at,
}: {
  id: ContactFormEnquiryType["id"];
  name: ContactFormEnquiryType["name"];
  email: ContactFormEnquiryType["email"];
  phone: ContactFormEnquiryType["phone"];
  subject: ContactFormEnquiryType["subject"];
  message: ContactFormEnquiryType["message"];
  page_url: ContactFormEnquiryType["page_url"];
  created_at: ContactFormEnquiryType["created_at"];
}) {
  const handleModalView = useContactFormEnquiryModalStore(
    (state) => state.handleModalView,
  );
  const onViewHandler = useCallback(() => {
    handleModalView(id);
  }, [id, handleModalView]);
  return (
    <tr>
      <td className="px-4 py-3 font-medium text-gray-900">
        <div className="flex items-center gap-2 py-1 ">
          <Avatar className="h-8 w-8 rounded-lg">
            <AvatarFallback className="rounded-lg">
              {getNameInitials(name)}
            </AvatarFallback>
          </Avatar>
          <div className="px-1">
            <p className="text-sm font-medium text-gray-800">{name}</p>
            <p className="truncate text-xs text-muted-foreground">{email}</p>
            {phone && (
              <p className="truncate text-xs text-slate-600">{phone}</p>
            )}
          </div>
        </div>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{subject}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">{message}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500">{page_url}</p>
      </td>
      <td className="px-4 py-3 ">
        <p className="text-sm text-gray-500 truncate">
          {format(created_at, "dd MMM yyyy, hh:mm a")}
        </p>
      </td>
      <td className="px-4 py-3 text-right">
        <div className="flex items-center gap-2 justify-end">
          <Button size="xs" variant="secondary" onClick={onViewHandler}>
            View
          </Button>
          <ContactFormEnquiryDeleteBtn id={id} />
        </div>
      </td>
    </tr>
  );
});

function ContactFormEnquiryTable({
  loading,
  enquiries,
}: ContactFormEnquiryTableProps) {
  return (
    <table className="w-full text-sm">
      <thead className="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
        <tr>
          {["Name", "Subject", "Message", "Page URL", "Created At", ""].map(
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
          <TableRowLoading colSpan={6} />
        ) : (
          enquiries.map((item) => (
            <ContactFormEnquiryTableRow
              key={item.id}
              id={item.id}
              name={item.name}
              email={item.email}
              phone={item.phone}
              subject={item.subject}
              message={item.message}
              page_url={item.page_url}
              created_at={item.created_at}
            />
          ))
        )}
      </tbody>
    </table>
  );
}

export default memo(ContactFormEnquiryTable);
