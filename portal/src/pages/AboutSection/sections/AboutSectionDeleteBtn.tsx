import { useAboutSectionDeleteMutation } from "@/utils/data/mutation/about_section";
import { useCallback } from "react";
import DeleteButton from "@/components/DeleteButton";

function AboutSectionDeleteBtn({ id }: { id: number }) {
  const aboutSectionDeleteMutation = useAboutSectionDeleteMutation(id);

  const onDelete = useCallback(async () => {
    await aboutSectionDeleteMutation.mutateAsync(undefined);
  }, [aboutSectionDeleteMutation.mutateAsync]);

  return (
    <DeleteButton
      onDelete={onDelete}
      loading={aboutSectionDeleteMutation.isPending}
    />
  );
}

export default AboutSectionDeleteBtn;
